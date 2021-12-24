<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Contrato de Locação n° 2021155122</title>

    <style>

    </style>
</head>

<body>
    <table id="bodyTable" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
        <tbody>
            <tr>
                <td id="bodyCell" align="center" valign="top">
                    <table class="templateContainer" border="0" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td id="templateHeader" valign="top">
                                    <table class="mcnImageBlock" style="min-width: 100%;" border="0" width="100%"
                                        cellspacing="0" cellpadding="0">
                                        <tbody class="mcnImageGroupBlockOuter">
                                            <tr>
                                                <td class="mcnImageBlockInner" style="padding: 0px 0px;" valign="top">
                                                    <table class="mcnImageContentContainer" style="min-width: 100%;"
                                                        border="0" width="100%" cellspacing="0" cellpadding="0"
                                                        align="left">
                                                        <tbody>
                                                            <tr>
                                                                <td class="mcnImageContent" valign="top"
                                                                    style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                                                    <img align="center" alt=""
                                                                        src="{{ $dataEmail['urlVoucherTemplate'] }}"
                                                                        width="600"
                                                                        style="max-width:600px; padding-bottom: 0; display: inline !important; vertical-align: bottom;"
                                                                        class="mcnImage">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td id="templateBody" valign="top">
                                    <table class="mcnTextBlock" style="min-width: 100%;" border="0" width="100%"
                                        cellspacing="0" cellpadding="0">
                                        <tbody class="mcnTextBlockOuter">
                                            <tr>
                                                <td class="mcnTextBlockInner" valign="top">
                                                    <table class="mcnTextContentContainer" style="min-width: 100%;"
                                                        border="0" width="100%" cellspacing="0" cellpadding="0"
                                                        align="left">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" class="mcnTextContent"
                                                                    style="padding-top:1px; padding-right: 18px; padding-bottom: 1px; padding-left: 28px; padding-right: 28px;border: 0px solid #fff;text-align: justify;">
                                                                    <span
                                                                        style="font-size:18px; font-weight: normal; line-height: 21px;">
                                                                        <center style="text-align: center">
                                                                            <br>
                                                                            <b>Olá, {{ $dataEmail['username'] }}!</b>
                                                                            <br><br>
                                                                        </center>
                                                                    </span>
                                                                    <span
                                                                        style="font-size:15px; font-weight: normal; line-height: 21px;">
                                                                        <center
                                                                            style="text-align: justify;font-size: 14px;">
                                                                            Você resgatou um
                                                                            <b>{{ $dataEmail['productName'] }}</b>
                                                                            exclusivo para adquirir produtos de sua
                                                                            preferência nas lojas físicas ou pelo site.
                                                                            {!! $dataEmail['providerDetails'] !!}
                                                                        </center>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" height="10px">
                                                                    <br />
                                                                    <hr noshade="noshade" size="3px" width="90%" />
                                                                    <br />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" class="mcnTextContent"
                                                                    style="padding-top:1px; padding-right: 18px; padding-bottom: 1px; padding-left: 28px; padding-right: 28px;border: 0px solid #fff;">
                                                                    <span style="font-size:15px; font-weight: normal;">
                                                                        <center
                                                                            style="text-align: justify; font-size: 14px;">
                                                                            @if ($dataEmail['isVirtual'])
                                                                                Em até
                                                                                {{ $dataEmail['deliveryTime'] }}
                                                                                ({{ $dataEmail['extensiveNumber'] }})
                                                                                dias
                                                                                úteis você receberá um código para
                                                                                utilização dos seus créditos. Para
                                                                                visualizar seu código, acesse: <a
                                                                                    href="{{ $dataEmail['url'] }}"
                                                                                    target="_blank"><b>{{ $dataEmail['url'] }}</b></a>,
                                                                                faça o login, clique em MEUS PEDIDOS e
                                                                                selecione um período para consulta.
                                                                            @else
                                                                                Em até
                                                                                {{ $dataEmail['deliveryTime'] }}
                                                                                ({{ $dataEmail['extensiveNumber'] }})
                                                                                dias
                                                                                úteis você receberá seu vale no endereço
                                                                                cadastrado. Caso não receba no período
                                                                                informado, envie um e-mail para
                                                                                <b>sac@hotshoponline.com.br</b>.
                                                                            @endif
                                                                        </center>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            @if ($dataEmail['isVirtual'])
                                                                <tr>
                                                                    <td colspan="2" height="10px">
                                                                        <br />
                                                                        <hr noshade="noshade" size="3px" width="90%" />
                                                                        <br />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" class="mcnTextContent" id="ms1"
                                                                        style="padding-top:1px; padding-right: 18px; padding-bottom: 10px; padding-left: 28px; padding-right: 28px;border: 0px solid #fff;text-align: justify;">
                                                                        <style type="text/css">
                                                                            #ms1 {
                                                                                margin: 20px 0;
                                                                            }

                                                                        </style>
                                                                        <span
                                                                            style="font-size:14px; font-weight: normal; line-height: 21px;">
                                                                            <center>
                                                                                Caso não visualize seu código no período
                                                                                informado acima, envie um e-mail para
                                                                                <b>sac@hotshoponline.com.br</b>.
                                                                            </center>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                        class="mcnImageCardBlock">
                                        <tbody class="mcnImageCardBlockOuter">
                                            <tr>
                                                <td class="mcnImageCardBlockInner" valign="top"
                                                    style="padding-top:9px; padding-bottom:9px; background-color: #A6A4A4;">
                                                    <table align="left" border="0" cellpadding="0" cellspacing="0"
                                                        class="mcnImageCardBottomContent" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="mcnTextContent" valign="top"
                                                                    style="padding: 7px 4px;color: #F2F2F2;font-family: Myriad Pro, sans-serif;font-size: 14px;font-weight: bold;text-align: center;"
                                                                    width="546">
                                                                    <br>
                                                                    <style type="text/css">
                                                                        .rodape {
                                                                            align-items: center;
                                                                            font-size: 15px;
                                                                            letter-spacing: 1px;
                                                                            text-align: center;
                                                                            text-decoration: none
                                                                        }

                                                                        @media (max-width: 498px) {
                                                                            .rodape {
                                                                                font-size: 18px;
                                                                            }
                                                                        }

                                                                    </style>
                                                                    <u class="rodape">
                                                                        <a href="{{ $dataEmail['url'] }}"
                                                                            style=" color: #ffffff; text-transform: uppercase;"
                                                                            target="_blank">{{ $dataEmail['url'] }}
                                                                        </a>
                                                                    </u>
                                                                    <br>
                                                                    <span
                                                                        style="color:#ffffff; font-size:9px; font-weight:normal">
                                                                        COPYRIGHT © 2005-
                                                                        @php
                                                                            echo date('Y');
                                                                        @endphp
                                                                        HSOL INCENTIVE PERFORMANCE
                                                                        S.A. | TODOS OS DIREITOS RESERVADOS.
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
