<?php

/* $user = isset($_GET['user']) ?$_GET['user']: 'weverton' ;
  $conf = include __DIR__ . '/../../database.php';
  $cred = $conf['weverton'];
  if ($cred['mode'] == 'prod') {
  $token = $cred['access_token'];
  } else if ($cred['mode'] == 'test') {
  $token = $cred['test_access_token'];
  }

  MercadoPago\SDK::setAccessToken($token); */

$conf = include __DIR__ . '/../../database.php';
$manager = $this->view->user->name;
echo 'Técnico responsavel: ' . $this->view->user->owner->name . '<br />';
$cred = $conf[$this->view->user->owner->name];
if ($cred['mode'] == 'prod') {
    $token = $cred['access_token'];
} else if ($cred['mode'] == 'test') {
    $token = $cred['test_access_token'];
}

// SDK de Mercado Pago
require __DIR__ . '/../../../vendor/autoload.php';

// Configura credenciais
MercadoPago\SDK::setAccessToken($token);


$merchant_order = null;

switch ($this->view->topic) {
    case "payment":
        $payment = MercadoPago\Payment::find_by_id($_GET["id"]);
        // Get the payment and the corresponding merchant_order reported by the IPN.
        $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);
        break;
    case "merchant_order":
        $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
        break;
}

$paid_amount = 0;
foreach ($merchant_order->payments as $payment) {
    if ($payment['status'] == 'approved') {
        $paid_amount += $payment['transaction_amount'];
    }
}

echo 'Transação: ' . $this->view->preference_id . '<br />';
switch ($this->view->status) {
    case 'pending':
        echo 'Aguardando a confirmação do pagamento<br />';
        break;
    case 'in_process':
        echo 'Aguardando a confirmação do pagamento<br />';
        break;
    case 'approved':
        echo 'Pagamento aprovado<br />';
        break;
    case'rejected':
        echo 'O pagamento foi recusado<br />';
        break;
}
$id = $this->view->payment_id;
$payment = MercadoPago\Payment::find_by_id($id);
$html = '';
$file = __DIR__ . '/../../../storage/'. $this->view->user->owner->name .'-log.txt';
$fp = fopen($file, 'a');
foreach ($_GET as $key => $value) {
    $html = date('d-m-Y H:i') . '|' . $this->view->payment_type. '|' . $payment->{'status'} . '|' . $payment->{'status_detail'} . '|' . $payment->{'description'} . '|' . $this->view->user->name . PHP_EOL;
}
$vencimento = date('Y-m-d', strtotime('+30 days', strtotime($payment->date_approved)));
//grava no log
$write = fwrite($fp, $html);
fclose($fp);
$servername = $conf['mysql']['host'];
$username = $conf['mysql']['user'];
$password = $conf['mysql']['pass'];
$dbname = $conf['mysql']['database'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
if (($payment->status != null) && ($payment->status == 'approved')) {
    $sql = "UPDATE users SET expires=ADDDATE(expires,INTERVAL 1 MONTH) WHERE id='" . $this->view->user->id . "'";
    $sql2 = "SELECT * WHERE id='" . $this->view->user->id . "'";
    if ($conn->query($sql) === TRUE) {
        echo "Dados do usuário atualizados, sua data de vencimento foi atualizada." . '<br />';
    } else {
        echo "Não foi possivel atualualizar a data de vencimento, erro: " . $conn->error;
    }
} else {
    echo "Ainda não recebemos o a confirmação do seu pagamento, nada foi alterado.";
}
$conn->close();
