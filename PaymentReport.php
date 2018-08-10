<?php
/**
 * Plugin Name: Simple Payment report
 * Plugin URI: https://angelcruz.me
 * Description: Only for Direct Bank Transfer, or Bank Account Clearing System (BACS) (Available only for Venezuela)
 * Text Domain: reportpayments
 * Version: 1.0.0
 * Author: Angel Cruz
 * Author URI: http://abr4xas.org
 * Requires at least: 4.9.6
 * Tested up to: 4.9.8
 *
 * @category Admin
 *
 * @author Angel Cruz
 * @copyright Copyright (C) Angel Cruz <me@abr4xas.org> and WooCommerce
 */
if (!defined('ABSPATH')) {
    exit;
}

function spr_shortcode($atts) {
    $order = new WC_Order($atts['orderid']);
    ob_start();

    if ($order->get_payment_method() == 'bacs' && $order->get_status() == 'on-hold') {
        if (isset($_POST['submit'])) {
            // sanitize form values
            $banco              = sanitize_text_field($_POST['banco']);
            $bancoreceptor      = sanitize_email($_POST['bancoreceptor']);
            $titular            = sanitize_text_field($_POST['titular']);
            $cedula             = sanitize_text_field($_POST['cedula']);
            $referencias        = esc_textarea($_POST['referencias']);
            $notas              = esc_textarea($_POST['notas']);

            $order->add_order_note(__('Reporte de pago: <br/>
                Banco Emisor: ' . $banco . '<br/>
                Banco Receptor: ' . $bancoreceptor . '<br/>
                Titular Cuenta: ' . $titular . '<br/>
                Rif o Cédula: ' . $cedula . '<br/>
                Referencias: ' . nl2br($referencias) . '<br/>
                Monto: ' . $order->get_total() . '<br/>
                Monto: ' . $order->get_order_number() . '<br/>
                Notas: ' . nl2br($notas) . '<br/>', 'woothemes')
            );
        } else {
        echo '<style>.report-payment{max-width:100%;width:100%;margin:0 auto;position:relative}#rpayment button[type=submit],#rpayment input[type=text],#rpayment input[type=email],#rpayment input[type=tel],#rpayment input[type=url],#rpayment textarea{font:400 12px/16px Roboto,Helvetica,Arial,sans-serif}#rpayment{padding:25px}#rpayment h3{display:block;font-size:30px;font-weight:300;margin-bottom:10px}#rpayment h4{margin:5px 0 15px;display:block;font-size:13px;font-weight:400}fieldset{border:none!important;margin:0 0 10px;min-width:100%;padding:0;width:100%}#rpayment input[type=text],#rpayment input[type=email],#rpayment input[type=tel],#rpayment input[type=url],#rpayment select,#rpayment textarea{width:100%;border:1px solid #ccc;background:#FFF;margin:0 0 5px;padding:10px}#rpayment input[type=text]:hover,#rpayment input[type=email]:hover,#rpayment input[type=tel]:hover,#rpayment input[type=url]:hover,#rpayment textarea:hover{-webkit-transition:border-color .3s ease-in-out;-moz-transition:border-color .3s ease-in-out;transition:border-color .3s ease-in-out;border:1px solid #aaa}#rpayment textarea{height:100px;max-width:100%;resize:none}#rpayment button[type=submit]{cursor:pointer;width:100%;border:none;background:#4CAF50;color:#FFF;margin:0 0 5px;padding:10px;font-size:15px}#rpayment button[type=submit]:hover{background:#43A047;-webkit-transition:background .3s ease-in-out;-moz-transition:background .3s ease-in-out;transition:background-color .3s ease-in-out}#rpayment button[type=submit]:active{box-shadow:inset 0 1px 3px rgba(0,0,0,.5)}.copyright{text-align:center}#rpayment input:focus,#rpayment textarea:focus{outline:0;border:1px solid #aaa}::-webkit-input-placeholder{color:#888}:-moz-placeholder{color:#888}::-moz-placeholder{color:#888}:-ms-input-placeholder{color:#888}</style>
        <div class="report-payment">
            <form id="rpayment" action="'.esc_url($_SERVER['REQUEST_URI']).'" method="post">
                <h3>Reporte su pago</h3>
                <hr>
                <fieldset>
                    <label for="banco">Banco Emisor</label>
                    <select name="banco" required>
                        <option>Seleccione</option>';
                        $bancos = [
                            '100% BANCO' => '100% BANCO',
                            'ABN AMRO BANK' => 'ABN AMRO BANK',
                            'ANCAMIGA BANCO MICROFINANCIERO, C.A.' => 'ANCAMIGA BANCO MICROFINANCIERO, C.A.',
                            'BANCO ACTIVO BANCO COMERCIAL, C.A.' => 'BANCO ACTIVO BANCO COMERCIAL, C.A.',
                            'BANCO AGRICOLA' => 'BANCO AGRICOLA',
                            'BANCO BICENTENARIO' => 'BANCO BICENTENARIO',
                            'BANCO CARONI, C.A. BANCO UNIVERSAL' => 'BANCO CARONI, C.A. BANCO UNIVERSAL',
                            'BANCO DE DESARROLLO DEL MICROEMPRESARIO' => 'BANCO DE DESARROLLO DEL MICROEMPRESARIO',
                            'BANCO DE VENEZUELA S.A.I.C.A' => 'BANCO DE VENEZUELA S.A.I.C.A',
                            'BANCO DEL CARIBE C.A.' => 'BANCO DEL CARIBE C.A.<',
                            'BANCO DEL PUEBLO SOBERANO C.A.' => 'BANCO DEL PUEBLO SOBERANO C.A.',
                            'BANCO DEL TESORO' => 'BANCO DEL TESORO',
                            'BANCO ESPIRITO SANTO, S.A.' => 'BANCO ESPIRITO SANTO, S.A.',
                            'BANCO EXTERIOR C.A.' => 'BANCO EXTERIOR C.A.',
                            'BANCO INDUSTRIAL DE VENEZUELA.' => 'BANCO INDUSTRIAL DE VENEZUELA.',
                            'BANCO INTERNACIONAL DE DESARROLLO, C.A.' => 'BANCO INTERNACIONAL DE DESARROLLO, C.A.',
                            'BANCO MERCANTIL C.A.' => 'BANCO MERCANTIL C.A.',
                            'BANCO NACIONAL DE CREDITO' => 'BANCO NACIONAL DE CREDITO',
                            'BANCO OCCIDENTAL DE DESCUENTO.' => 'BANCO OCCIDENTAL DE DESCUENTO.',
                            'BANCO PLAZA' => 'BANCO PLAZA',
                            'BANCO PROVINCIAL BBVA' => 'BANCO PROVINCIAL BBVA',
                            'BANCO VENEZOLANO DE CREDITO S.A.' => 'BANCO VENEZOLANO DE CREDITO S.A.',
                            'BANCRECER S.A. BANCO DE DESARROLLO' => 'BANCRECER S.A. BANCO DE DESARROLLO',
                            'BANESCO BANCO UNIVERSAL' => 'BANESCO BANCO UNIVERSAL',
                            'BANFANB' => 'BANFANB',
                            'BANGENTE' => 'BANGENTE',
                            'BANPLUS BANCO COMERCIAL C.A' => 'BANPLUS BANCO COMERCIAL C.A',
                            'CITIBANK' => 'CITIBANK',
                            'CORP BANCA' => 'CORP BANCA',
                            'DELSUR BANCO UNIVERSAL' => 'DELSUR BANCO UNIVERSAL',
                            'FONDO COMUN' => 'FONDO COMUN',
                            'INSTITUTO MUNICIPAL DE CRÉDITO POPULAR' => 'INSTITUTO MUNICIPAL DE CRÉDITO POPULAR',
                            'MIBANCO BANCO DE DESARROLLO, C.A.' => 'MIBANCO BANCO DE DESARROLLO, C.A.',
                            'SOFITASA' => 'SOFITASA',
                        ];
                        foreach ($bancos as $key => $value) {
                            echo '<option value="'.$key.'">'.$value.'</option>';
                        }
                        echo '
                    </select>
                </fieldset>
                <fieldset>
                    <label for="banco">Banco Receptor</label>
                    <select name="bancoreceptor" required>
                        <option>Seleccione</option>';
                        $receptor = [
                            'BANCO NACIONAL DE CREDITO' => 'BANCO NACIONAL DE CREDITO',
                            'BANESCO BANCO UNIVERSAL'   => 'BANESCO BANCO UNIVERSAL',
                        ];
                        foreach ($receptor as $key => $value) {
                            echo '<option value="'.$key.'">'.$value.'</option>';
                        }
                        echo '
                    </select>
                </fieldset>
                <fieldset>
                    <label for="banco">Titular de la cuenta</label>
                    <input name="titular" placeholder="Titular de la cuenta" type="text" required>
                </fieldset>
                <fieldset>
                    <label for="banco">Cédula del titular o RIF</label>
                    <input name="cedula" placeholder="Cédula del titular o RIF" type="text" required>
                </fieldset>
                <fieldset>
                    <label for="banco">Número de referencia</label>
                    <textarea name="referencias" placeholder="Número de referencia" tabindex="5" required></textarea>
                    <small>Si fuese más de una transferencia colocar el número de referencia por línea.</small>
                </fieldset>
                <fieldset>
                    <label for="banco">Monto de la transferencia</label>
                    <input name="monto" value="'.$order->get_total().'" type="text" readonly>
                </fieldset>
                <fieldset>
                    <label for="banco">Número de Pedido</label>
                    <input name="numorden" value="'.$order->get_order_number().'"type="text" readonly>
                </fieldset>
                <fieldset>
                    <label for="banco">Notas (opcional)</label>
                    <textarea name="notas" placeholder="Notas (opcional)" tabindex="5" required></textarea>
                </fieldset>
                <fieldset>
                    <button name="submit" type="submit" id="rpayment-submit" data-submit="...Sending">
                        Enviar
                    </button>
                </fieldset>
            </form>
        </div>';
        }
    }

    return ob_get_clean();
}

add_shortcode('simple_payment_report', 'spr_shortcode');
?>