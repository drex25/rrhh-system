<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recibo de Haberes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        .main-table {
            width: 100%;
            table-layout: fixed;
            border: none;
        }

        .main-table td {
            vertical-align: top;
            border: none;
            padding: 0;
        }

        .recibo-box {
            border: 1px solid #222;
            padding: 0;
            margin: 0;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .header-table td,
        .header-table th {
            border: none;
            padding: 0;
        }

        .empresa-title {
            font-size: 13px;
            font-weight: bold;
            text-align: left;
        }

        .recibo-title {
            font-size: 16px;
            font-weight: bold;
            text-align: left;
        }

        .empresa-data {
            font-size: 11px;
            text-align: left;
        }

        .empresa-cuit {
            font-size: 11px;
            text-align: right;
        }

        .subtitle {
            font-size: 11px;
            text-align: left;
            margin-bottom: 4px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid #222;
            border-collapse: collapse;
        }

        .table {
            width: 100%;
            margin-bottom: 6px;
        }

        .table th,
        .table td {
            padding: 2px 4px;
            font-size: 10px;
        }

        .table th {
            background: #f3f3f3;
            font-weight: bold;
            text-align: center;
        }

        .table td.desc {
            text-align: left;
        }

        .table td.center {
            text-align: center;
        }

        .totales-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        .totales-table td {
            font-size: 11px;
            padding: 2px 4px;
            border: none;
        }

        .totales-label {
            font-weight: bold;
            text-align: right;
        }

        .totales-value {
            font-weight: bold;
            text-align: right;
        }

        .footer {
            font-size: 10px;
            margin-top: 8px;
        }

        .firma {
            margin-top: 18px;
            text-align: center;
            font-size: 11px;
        }

        .firma .line {
            border-top: 1px solid #222;
            width: 60%;
            margin: 0 auto 2px auto;
        }

        .firma-img {
            height: 30px;
            margin-bottom: 2px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .mt-2 {
            margin-top: 2px;
        }

        .mt-4 {
            margin-top: 4px;
        }

        .mb-2 {
            margin-bottom: 2px;
        }

        .mb-4 {
            margin-bottom: 4px;
        }

        .cut-line {
            border-left: 1.5px dashed #888;
            width: 0;
        }
    </style>
</head>

<body>
    <table class="main-table">
        <tr>
            @foreach (['ORIGINAL', 'DUPLICADO'] as $i => $tipo)
                <td style="width: 49.5%; padding: 8px 8px 0 8px;">
                    <div class="recibo-box">
                        <table class="header-table" style="margin-bottom: 2px;">
                            <tr>
                                <td style="width: 60%; vertical-align: top;">
                                    <span class="recibo-title">{{ $tipo }}</span><br>
                                    <span class="empresa-title">Recibo de Haberes</span>
                                </td>
                                <td style="width: 40%; text-align: right; vertical-align: top;">
                                    <span class="empresa-title">THINK SOLUTIONS SRL -RONDA 360 S.R.L UTE</span><br>
                                    <span class="empresa-data">Dirección: BOLIVAR, POSADAS 3300</span><br>
                                    <span class="empresa-cuit">CUIT: 30-71729073-5 &nbsp; Nro.: 1729 &nbsp; Piso: &nbsp;
                                        Depto.:</span>
                                </td>
                            </tr>
                        </table>
                        <div class="empresa-data" style="margin-bottom: 2px;">Servicios de consultores en tecnología de
                            la información</div>
                        <table class="table mb-2">
                            <tr>
                                <th>PERÍODO ABONADO</th>
                                <th>DESCRIPCIÓN DEL PAGO</th>
                                <th>FECHA DE PAGO</th>
                                <th>LUGAR DE PAGO</th>
                            </tr>
                            <tr>
                                <td class="center">{{ $payslip->period_start->format('m/Y') }}</td>
                                <td class="center">
                                    {{ $payslip->period_description ?? $payslip->period_start->translatedFormat('F Y') }}
                                </td>
                                <td class="center">{{ $payslip->payment_date->format('d/m/Y') }}</td>
                                <td class="center">{{ $payslip->payment_place ?? 'MISIONES' }}</td>
                            </tr>
                            <tr>
                                <th>LEGAJO</th>
                                <th>APELLIDO Y NOMBRE DEL EMPLEADO</th>
                                <th colspan="2">C.U.I.L.</th>
                            </tr>
                            <tr>
                                <td class="center">{{ $payslip->employee->file_number ?? '' }}</td>
                                <td class="center">{{ $payslip->employee->full_name ?? '' }}</td>
                                <td class="center" colspan="2">{{ $payslip->employee->cuit ?? '' }}</td>
                            </tr>
                        </table>
                        <table class="table mb-2">
                            <tr>
                                <td style="font-size:10px;">Sueldo / Jornal:
                                    <b>{{ number_format($payslip->gross_salary, 2, ',', '.') }}</b></td>
                                <td style="font-size:10px;">Categoría:
                                    <b>{{ $payslip->employee->position->title ?? '' }}</b></td>
                                <td style="font-size:10px;">Tarea:
                                    <b>{{ $payslip->employee->position->description ?? '' }}</b></td>
                            </tr>
                            <tr>
                                <td style="font-size:10px;">Obra Social:
                                    <b>{{ $payslip->employee->health_insurance ?? '' }}</b></td>
                                <td style="font-size:10px;">Ingreso:
                                    <b>{{ $payslip->employee->hire_date ? $payslip->employee->hire_date->format('d/m/Y') : '' }}</b>
                                </td>
                                <td style="font-size:10px;">Depósito previsional:
                                    <b>{{ $payslip->bank_account ?? 'Banco Macro de Misiones SA' }}</b></td>
                            </tr>
                            <tr>
                                <td style="font-size:10px;">Obra social: OS WITCEL</td>
                                <td style="font-size:10px;">Período: 02/2025</td>
                                <td style="font-size:10px;">Fecha: 11/03/2025</td>
                            </tr>
                        </table>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Descripción</th>
                                    <th>Cód.</th>
                                    <th>Unid.</th>
                                    <th>Haberes</th>
                                    <th>Retenciones</th>
                                    <th>Adicionales</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $conceptos = array_merge($payslip->allowances ?? [], $payslip->deductions ?? []);
                                @endphp
                                @foreach ($conceptos as $item)
                                    <tr>
                                        <td class="desc">{{ $item['descripcion'] ?? ($item['description'] ?? '') }}
                                        </td>
                                        <td class="center">{{ $item['codigo'] ?? ($item['code'] ?? '') }}</td>
                                        <td class="center">{{ $item['unidades'] ?? ($item['units'] ?? '') }}</td>
                                        <td>{{ isset($item['haberes']) ? number_format($item['haberes'], 2, ',', '.') : '' }}
                                        </td>
                                        <td>{{ isset($item['retenciones']) ? number_format($item['retenciones'], 2, ',', '.') : '' }}
                                        </td>
                                        <td>{{ isset($item['adicionales']) ? number_format($item['adicionales'], 2, ',', '.') : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="totales-table">
                            <tr>
                                <td class="totales-label" style="width: 20%;">Total bruto :</td>
                                <td class="totales-value" style="width: 20%;">
                                    {{ number_format($payslip->gross_salary, 2, ',', '.') }}</td>
                                <td class="totales-label" style="width: 20%;">Totales :</td>
                                <td class="totales-value" style="width: 20%;">
                                    {{ number_format($payslip->deductions_total ?? 0, 2, ',', '.') }}</td>
                                <td class="totales-value" style="width: 20%;">
                                    {{ number_format($payslip->allowances_total ?? 0, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="totales-label">Total neto :</td>
                                <td class="totales-value">{{ number_format($payslip->net_salary, 2, ',', '.') }}</td>
                                <td colspan="3"></td>
                            </tr>
                        </table>
                        <div class="footer mt-4">
                            Recibí conforme la suma de pesos: <b>{{ $payslip->net_salary_text ?? '' }}</b><br>
                            Depositados en: <b>{{ $payslip->bank_account ?? 'Banco Macro de Misiones SA' }}</b><br>
                            En concepto de haberes correspondiente al período arriba indicado y según la presente
                            liquidación, dejando constancia de haber recibido un duplicado de este recibo.
                        </div>
                        <div class="firma mt-4">
                            <div class="line"></div>
                            <div>Firma del empleado</div>
                        </div>
                    </div>
                </td>
                @if ($i == 0)
                    <td class="cut-line"></td>
                @endif
            @endforeach
        </tr>
    </table>
</body>

</html>
