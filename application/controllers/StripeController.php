<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @desc Test payments
 * @url https://dashboard.stripe.com/test/payments
 * @author Rakesh Maity
 */
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Response;
class StripeController extends CI_Controller {
    private $response;
    private $intent;
    public function __construct()
    {
        parent::__construct();
        $this->init();
    }
    public function setResponse($response) {
        $this->response = $response;
        return $this;
    }
    public function getResponse() {
        return $this->response;
    }
    public function sendResponse() {
        $this->response->send();
    }
    
    public function init() {
        Stripe::setApiKey("sk_test_o5nGXpdRlws3GgpwcOgxzRaP");
        Stripe::setVerifySslCerts(false);

    }
    public function setIntent($intent) {
        $this->intent = $intent;
        return $this;
    }
    /**
     * @desc Get list of payments
     * @url v1/payment_intents/list
     * @method GET
     */
 
    public function list() {
        try {
            $this->setIntent(PaymentIntent::all(["limit" => 3]));
            $this->setResponse(new Response(
                array(
                    'data' => $this->intent,
                    'status' => Response::HTTP_OK,
                    'message' => Response::$statusTexts[200]
                ),
                Response::HTTP_OK,
                ['Content-Type', 'application/json']
            ));
        } catch(\Exception $ex) {
            $this->setResponse(new Response(
                array(
                    'data' => [],
                    'status' => Response::HTTP_OK,
                    'message' => $ex->getMessage()
                ),
                Response::HTTP_OK,
                ['Content-Type', 'application/json']
            ));
        }
        
        
        $this->sendResponse();
    }

    /**
     * @desc Make a payment
     * @url v1/payment_intents/list
     * @method POST
     * @response
     * {
            "data": {
                "id": "pi_1FN9ddCP2gh5ZnOcPEUuVrPQ",
                "object": "payment_intent",
                "allowed_source_types": [
                    "card"
                ],
                "amount": 2000,
                "amount_capturable": 0,
                "amount_received": 0,
                "application": null,
                "application_fee_amount": null,
                "canceled_at": null,
                "cancellation_reason": null,
                "capture_method": "automatic",
                "charges": {
                    "object": "list",
                    "data": [],
                    "has_more": false,
                    "total_count": 0,
                    "url": "/v1/charges?payment_intent=pi_1FN9ddCP2gh5ZnOcPEUuVrPQ"
                },
                "client_secret": "pi_1FN9ddCP2gh5ZnOcPEUuVrPQ_secret_xLT5jZImgzsHRKVfVcKOoZKFz",
                "confirmation_method": "automatic",
                "created": 1569553017,
                "currency": "usd",
                "customer": null,
                "description": null,
                "invoice": null,
                "last_payment_error": null,
                "livemode": false,
                "metadata": [],
                "next_action": null,
                "next_source_action": null,
                "on_behalf_of": null,
                "payment_method": null,
                "payment_method_options": {
                    "card": {
                        "request_three_d_secure": "automatic"
                    }
                },
                "payment_method_types": [
                    "card"
                ],
                "receipt_email": null,
                "review": null,
                "setup_future_usage": null,
                "shipping": null,
                "source": null,
                "statement_descriptor": null,
                "statement_descriptor_suffix": null,
                "status": "requires_source",
                "transfer_data": null,
                "transfer_group": null
            },
            "status": 200,
            "message": "OK"
        }
     */
    public function create() {
        try {
            $this->setIntent(PaymentIntent::create([
                'amount' => 2000,
                'currency' => 'usd',
                'payment_method_types' => ['card'],
              ]));
            $this->setResponse(new Response(
                array(
                    'data' => $this->intent,
                    'status' => Response::HTTP_OK,
                    'message' => Response::$statusTexts[200]
                ),
                Response::HTTP_OK,
                ['Content-Type', 'application/json']
            ));
        } catch(\Exception $ex) {
            $this->setResponse(new Response(
                array(
                    'data' => [],
                    'status' => Response::HTTP_OK,
                    'message' => $ex->getMessage()
                ),
                Response::HTTP_OK,
                ['Content-Type', 'application/json']
            ));
        }
        
        
        $this->sendResponse();
    }
    /**
     * 
     * 
        
     */

     /**
     * @desc RETRIEVE A PAYMENTINTENT
     * @url v1/payment_intents/:id
     * @method GET
     * @response
     * {
        "data": {
            "id": "pi_1FN9ddCP2gh5ZnOcPEUuVrPQ",
            "object": "payment_intent",
            "allowed_source_types": [
                "card"
            ],
            "amount": 2000,
            "amount_capturable": 0,
            "amount_received": 0,
            "application": null,
            "application_fee_amount": null,
            "canceled_at": null,
            "cancellation_reason": null,
            "capture_method": "automatic",
            "charges": {
                "object": "list",
                "data": [],
                "has_more": false,
                "total_count": 0,
                "url": "/v1/charges?payment_intent=pi_1FN9ddCP2gh5ZnOcPEUuVrPQ"
            },
            "client_secret": "pi_1FN9ddCP2gh5ZnOcPEUuVrPQ_secret_xLT5jZImgzsHRKVfVcKOoZKFz",
            "confirmation_method": "automatic",
            "created": 1569553017,
            "currency": "usd",
            "customer": null,
            "description": null,
            "invoice": null,
            "last_payment_error": null,
            "livemode": false,
            "metadata": [],
            "next_action": null,
            "next_source_action": null,
            "on_behalf_of": null,
            "payment_method": null,
            "payment_method_options": {
                "card": {
                    "request_three_d_secure": "automatic"
                }
            },
            "payment_method_types": [
                "card"
            ],
            "receipt_email": null,
            "review": null,
            "setup_future_usage": null,
            "shipping": null,
            "source": null,
            "statement_descriptor": null,
            "statement_descriptor_suffix": null,
            "status": "requires_source",
            "transfer_data": null,
            "transfer_group": null
        },
        "status": 200,
        "message": "OK"
    }
     */
    public function get() {
        try {
            $this->setIntent(PaymentIntent::retrieve('pi_1FN9ddCP2gh5ZnOcPEUuVrPQ'));
            $this->setResponse(new Response(
                array(
                    'data' => $this->intent,
                    'status' => Response::HTTP_OK,
                    'message' => Response::$statusTexts[200]
                ),
                Response::HTTP_OK,
                ['Content-Type', 'application/json']
            ));
        } catch(\Exception $ex) {
            $this->setResponse(new Response(
                array(
                    'data' => [],
                    'status' => Response::HTTP_OK,
                    'message' => $ex->getMessage()
                ),
                Response::HTTP_OK,
                ['Content-Type', 'application/json']
            ));
        }
        
        
        $this->sendResponse();
    }
}
