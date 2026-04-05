<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $permit->document_type }} #{{ $permit->number }}</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: Arial, sans-serif; font-size: 13px; background: #fff; color: #111; }
  .page { max-width: 800px; margin: 0 auto; padding: 40px 40px 60px; }

  .header { display: flex; align-items: flex-start; gap: 30px; border-bottom: 2px solid #111; padding-bottom: 16px; margin-bottom: 20px; }
  .header img { width: 90px; height: auto; flex-shrink: 0; }
  .header-text { flex: 1; }
  .header-text .ministry { font-weight: bold; font-size: 13px; text-transform: uppercase; line-height: 1.6; }
  .header-text .sub { font-size: 12px; color: #333; line-height: 1.5; margin-top: 4px; }
  .header-text .en { font-size: 11px; color: #555; margin-top: 8px; line-height: 1.5; }

  .doc-title { text-align: center; font-size: 15px; font-weight: bold; text-transform: uppercase; margin: 18px 0 6px; letter-spacing: 1px; }
  .doc-ref   { text-align: center; font-size: 13px; color: #333; margin-bottom: 20px; }

  .info-block { margin-bottom: 8px; }
  .info-block strong { display: inline; font-weight: bold; }

  table { width: 100%; border-collapse: collapse; margin-top: 16px; }
  table th, table td { border: 1px solid #aaa; padding: 7px 10px; font-size: 12px; vertical-align: top; }
  table th { background: #f0f0f0; font-weight: bold; width: 40%; }

  .countries { margin-top: 4px; }
  .countries span { display: inline-block; background: #eee; border: 1px solid #ccc; border-radius: 3px; padding: 2px 6px; margin: 2px; font-size: 11px; }

  .footer { margin-top: 40px; text-align: center; font-size: 11px; color: #888; border-top: 1px solid #ddd; padding-top: 12px; }

  @media print {
    body { background: #fff; }
    .page { padding: 20px; }
  }
</style>
</head>
<body>
<div class="page">

  {{-- Cabeçalho --}}
  <div class="header">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Coat_of_arms_of_Mozambique.svg/200px-Coat_of_arms_of_Mozambique.svg.png" alt="Armas">
    <div class="header-text">
      <div class="ministry">
        República de Moçambique<br>
        Ministério dos Transportes e Comunicações<br>
        Direcção Nacional de Transportes e Segurança Rodoviária
      </div>
      <div class="en">
        Republic of Mozambique<br>
        Ministry of Transport and Communications<br>
        National Directorate of Transport and Road Safety
      </div>
    </div>
  </div>

  {{-- Título --}}
  <div class="doc-title">{{ $permit->document_type }}</div>
  <div class="doc-ref">Nº {{ $permit->number }}</div>

  {{-- Info principal --}}
  <div class="info-block"><strong>Referência / Reference:</strong> {{ $permit->reference }}</div>
  <div class="info-block"><strong>Cliente / Client:</strong> {{ $permit->client_name }}</div>
  @if($permit->nuit)
  <div class="info-block"><strong>NUIT:</strong> {{ $permit->nuit }}</div>
  @endif

  {{-- Tabela de detalhes --}}
  <table>
    <tr>
      <th>Data de Emissão / Emission Date</th>
      <td>{{ $permit->issued_at->format('d/m/Y') }}</td>
    </tr>
    <tr>
      <th>Data de Validade / Valid Date</th>
      <td>{{ $permit->expires_at->format('d/m/Y') }}</td>
    </tr>
    <tr>
      <th>Estado / Status</th>
      <td>{{ $permit->status_label }}</td>
    </tr>
    @if($permit->vehicle_registration)
    <tr>
      <th>Matrícula / Registration</th>
      <td>{{ $permit->vehicle_registration }}</td>
    </tr>
    @endif
    @if($permit->vehicle_brand)
    <tr>
      <th>Marca / Brand</th>
      <td>{{ $permit->vehicle_brand }}</td>
    </tr>
    @endif
    @if($permit->cargo_type)
    <tr>
      <th>Tipo de Carga / Cargo Type</th>
      <td>{{ $permit->cargo_type }}</td>
    </tr>
    @endif
    @if($permit->capacity)
    <tr>
      <th>Capacidade / Capacity</th>
      <td>{{ $permit->capacity }}</td>
    </tr>
    @endif
    @if($permit->origin)
    <tr>
      <th>Origem / Origin</th>
      <td>{{ $permit->origin }}</td>
    </tr>
    @endif
    @if($permit->transit_countries && count($permit->transit_countries))
    <tr>
      <th>Países de Trânsito / Transit Countries</th>
      <td>
        <div class="countries">
          @foreach($permit->transit_countries as $country)
            <span>{{ $country }}</span>
          @endforeach
        </div>
      </td>
    </tr>
    @endif
  </table>

  <div class="footer">
    Documento verificado pelo sistema Balcão Virtual &middot; MTC Moçambique
  </div>

</div>
</body>
</html>
