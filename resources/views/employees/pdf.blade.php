<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Empleado</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 8pt;
            line-height: 1.3;
            color: #333;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
        }
        .header h1 {
            color: #1e40af;
            font-size: 14pt;
            margin: 0;
            font-weight: 600;
        }
        .header p {
            color: #4b5563;
            margin: 2px 0;
            font-size: 9pt;
        }
        .main-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .column {
            flex: 1;
            min-width: 300px;
        }
        .section {
            margin-bottom: 12px;
            background: #f8fafc;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        .section-title {
            color: #1e40af;
            font-size: 9pt;
            font-weight: 600;
            margin-bottom: 4px;
            padding-bottom: 2px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-item {
            display: flex;
            margin-bottom: 3px;
            font-size: 8pt;
        }
        .label {
            font-weight: 600;
            color: #4b5563;
            min-width: 120px;
        }
        .value {
            color: #1f2937;
            flex: 1;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 7pt;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 8px;
        }
        .highlight {
            background-color: #f3f4f6;
            padding: 2px 4px;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FICHA DE EMPLEADO</h1>
        <p>TS Group - Recursos Humanos</p>
    </div>

    <div class="main-container">
        <div class="column">
            <div class="section">
                <div class="section-title">Información Personal</div>
                <div class="info-item">
                    <span class="label">Nombre:</span>
                    <span class="value highlight">{{ $employee->first_name }} {{ $employee->last_name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">DNI:</span>
                    <span class="value">{{ $employee->dni }}</span>
                </div>
                <div class="info-item">
                    <span class="label">CUIT:</span>
                    <span class="value">{{ $employee->cuit }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Nacimiento:</span>
                    <span class="value">{{ $employee->birth_date->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Nacionalidad:</span>
                    <span class="value">{{ $employee->nationality }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Género:</span>
                    <span class="value">{{ $employee->gender }}</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Información de Contacto</div>
                <div class="info-item">
                    <span class="label">Dirección:</span>
                    <span class="value">{{ $employee->address }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Teléfono:</span>
                    <span class="value">{{ $employee->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Email:</span>
                    <span class="value">{{ $employee->email }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Emergencia:</span>
                    <span class="value">{{ $employee->emergency_contact_name }} ({{ $employee->emergency_contact_phone }})</span>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="section">
                <div class="section-title">Información Laboral</div>
                <div class="info-item">
                    <span class="label">Legajo:</span>
                    <span class="value highlight">{{ $employee->file_number }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Departamento:</span>
                    <span class="value">{{ $employee->department->name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Cargo:</span>
                    <span class="value">{{ $employee->position->name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Ingreso:</span>
                    <span class="value">{{ $employee->hire_date->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Contrato:</span>
                    <span class="value">{{ $employee->employment_type }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Horario:</span>
                    <span class="value">{{ $employee->work_schedule_from }} - {{ $employee->work_schedule_to }}</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Información Bancaria</div>
                <div class="info-item">
                    <span class="label">Banco:</span>
                    <span class="value">{{ $employee->bank_name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Cuenta:</span>
                    <span class="value">{{ $employee->bank_account }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Seguridad Social:</span>
                    <span class="value">{{ $employee->social_security_number }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Obra Social:</span>
                    <span class="value">{{ $employee->health_insurance }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Sindicato:</span>
                    <span class="value">{{ $employee->union }}</span>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="section">
                <div class="section-title">Información Familiar</div>
                <div class="info-item">
                    <span class="label">Madre:</span>
                    <span class="value">{{ $employee->mother_name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Padre:</span>
                    <span class="value">{{ $employee->father_name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Cónyuge:</span>
                    <span class="value">{{ $employee->spouse_name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Hijos:</span>
                    <span class="value">{{ $employee->children }}</span>
                </div>
            </div>

            @if($employee->notes)
            <div class="section">
                <div class="section-title">Notas</div>
                <div class="info-item">
                    <span class="value">{{ $employee->notes }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }} | Documento confidencial</p>
    </div>
</body>
</html> 