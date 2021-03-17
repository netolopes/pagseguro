<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function index()
    {

        // FUNCAO PARA CRIAR A SESSAO NO PAGUE SEGURO
        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            echo "<strong>ID de sess&atilde;o criado: </strong>{$sessionCode->getResult()}";
            return $sessionCode->getResult();
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }


    public function  payment(){

         // FUNCAO PARA PGTO CARTAO DE CREDITO

        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();


        $creditCard->setReceiverEmail('netolopes27@gmail.com');


        $creditCard->setReference("LIBPHP000001");


        $creditCard->setCurrency("BRL");


        $creditCard->addItems()->withParameters(
            '0001',
            'Notebook prata',
            2,
            10.00
        );


        $creditCard->addItems()->withParameters(
            '0002',
            'Notebook preto',
            2,
            5.00
        );

        // Set your customer information.
        // If you using SANDBOX you must use an email @sandbox.pagseguro.com.br
        $creditCard->setSender()->setName('João Comprador');
        $creditCard->setSender()->setEmail('v70473604112502375438@sandbox.pagseguro.com.br');

        $creditCard->setSender()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setSender()->setDocument()->withParameters(
            'CPF',
            '27121238918'
        );

        $creditCard->setSender()->setHash('d94d002b6998ca9cd69092746518e50aded5a54aef64c4877ccea02573694986');

        $creditCard->setSender()->setIp('127.0.0.0');

        // Set shipping information for this payment request
        $creditCard->setShipping()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        //Set billing information for credit card
        $creditCard->setBilling()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );


        $creditCard->setToken('2ed34e61b24d4ea8ae872c66a512525c');



        $creditCard->setInstallment()->withParameters(1, '30.00');


        $creditCard->setHolder()->setBirthdate('01/10/1979');
        $creditCard->setHolder()->setName('João Comprador'); // Equals in Credit Card

        $creditCard->setHolder()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setHolder()->setDocument()->withParameters(
            'CPF',
            '27121238918'
        );


        $creditCard->setMode('DEFAULT');



        try {

            $result = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
            echo "<pre>";
            print_r($result);
        } catch (Exception $e) {
            echo "</br> <strong>";
            die($e->getMessage());
        }


    }


}
