<?php

namespace App\Http\Controllers;

use URL;
use Input;
use Config;
use Session;
use Redirect;
use Validator;
use App\Vazhipad;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Api\RedirectUrls;
use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PPConnectionException;

class EbookingController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);

        return $this->middleware('auth');
    }

    public function index()
    {
        return view('ebooking.index');
    }

    public function store(Request $request)
    {
        $bills = json_decode($request->bills, true);

        $validator = Validator::make($bills, [
            '*.vazhipad_id' => ['bail', 'exists:vazhipads,id', function ($attribute, $value, $fail) {
                $permisison = optional(Vazhipad::find($value))->permission;
                if ($permisison != 'all' && $permisison != 'web') {
                    $fail($attribute . ' is not allowed to be created through web app');
                }
            }],
            '*.prathishtta_id' => ['exists:prathishttas,id'],
            '*.name' => ['required', 'string', 'max:255'],
            '*.nakshatharam_id' => ['exists:nakshatharams,id'],
            '*.date' => ['required', 'date'],
            '*.ennam' => ['required', 'numeric', 'gte:1'],
            '*.price' => ['required', 'numeric', 'gte:1'],
            '*.samayam' => ['required', 'in:0,1,2']
        ])->validate();

        $bills = collect($bills)->map(function ($bill) {
            return (object) $bill;
        });

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items = collect([]);

        foreach ($bills as $bill) {
            $item = new Item();
            $item->setName(Vazhipad::find($bill->vazhipad_id)->name) /** item name **/
                ->setCurrency('INR')
                ->setQuantity($bill->ennam)
                ->setPrice($bill->price); /** unit price **/
            $items->push($item);
        }

        $item_list = new ItemList();
        $item_list->setItems($items->toArray());

        $totalAmount = $bills->reduce(function ($acc, $bill) {
            return $acc + ($bill->ennam * $bill->price);
        }, 0);
        $amount = new Amount();
        $amount->setCurrency('INR')
            ->setTotal($totalAmount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Kesavapuram Sreekrishna Swamy Temple Online Vazhipad Booking');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('ebooking.status')) /** Specify return URL **/
            ->setCancelUrl(URL::route('ebooking.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (PPConnectionException $ex) {
            if (Config::get('app.debug')) {
                Session::put('error', 'Connection timeout');
                return Redirect::route('ebooking.index');
            } else {
                Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('ebooking.index');
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }

        Session::put('error', 'Unknown error occurred');
        return Redirect::route('ebooking.index');
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            Session::put('error', 'Payment failed');
            return Redirect::route('/');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            Session::put('success', 'Payment success');
            return Redirect::route('/');
        }

        Session::put('error', 'Payment failed');
        return Redirect::route('/');
    }
}
