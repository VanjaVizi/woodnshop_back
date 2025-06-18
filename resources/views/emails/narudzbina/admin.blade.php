@component('mail::message')
# Nova narudžbina na sajtu

Kupac: **{{ $narudzbina->ime }} {{ $narudzbina->prezime }}**  
Email: [{{ $narudzbina->email }}](mailto:{{ $narudzbina->email }})  
Telefon: {{ $narudzbina->telefon }}  
Grad: {{ $narudzbina->grad }}  
Adresa: {{ $narudzbina->adresa }}  
Način plaćanja: {{ $narudzbina->placanje === 'pouzecem' ? 'Pouzećem' : 'Na račun unapred' }}

---

### Stavke narudžbine:

@foreach ($narudzbina->stavke as $stavka)
- **{{ $stavka->naziv_proizvoda }}**
  @if ($stavka->dimenzija) (Dimenzija: {{ $stavka->dimenzija }}) @endif  
  Količina: {{ $stavka->kolicina }}  
  Cena: {{ $stavka->cena_na_upit ? 'Na upit' : number_format($stavka->cena, 2) . ' RSD' }}  
  @if ($stavka->napomena_kupca)
  Napomena: _{{ $stavka->napomena_kupca }}_
  @endif

@endforeach

---

**Ukupno stavki:** {{ $narudzbina->stavke->count() }}  
**Ukupna cena:** {{ number_format($narudzbina->stavke->sum(fn($s) => $s->cena * $s->kolicina), 2) }} RSD + poštarina

@endcomponent
