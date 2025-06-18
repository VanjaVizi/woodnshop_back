@component('mail::message')
# Poštovani {{ $narudzbina->ime }},

Vaša narudžbina je uspešno kreirana!  
U narednom periodu bićete kontaktirani radi **potvrde porudžbine**, provere mogućnosti izrade, kao i dogovora oko dostave.

📦 Cena dostave se kreće **od 300 RSD pa naviše**, u zavisnosti od dimenzija i težine paketa.  
Ukoliko ste izabrali **plaćanje unapred**, instrukcije za uplatu će Vam biti poslate kada narudžbina bude potvrđena.

@if($narudzbina->stavke->count())
---

### Pregled narudžbine:

@foreach ($narudzbina->stavke as $stavka)
- **{{ $stavka->naziv_proizvoda }}**
  @if ($stavka->dimenzija) (Dimenzija: {{ $stavka->dimenzija }}) @endif  
  Količina: {{ $stavka->kolicina }}  
  Cena: {{ $stavka->cena_na_upit ? 'Na upit' : number_format($stavka->cena, 2) . ' RSD' }}  
  @if ($stavka->napomena_kupca)
  Napomena: _{{ $stavka->napomena_kupca }}_
  @endif

@endforeach
@endif

---

**Ukupna cena (bez dostave):** {{ number_format($narudzbina->stavke->sum(fn($s) => $s->cena * $s->kolicina), 2) }} RSD + poštarina

Hvala Vam na poverenju!  
Tim **WOOD'N'SHOP**

@endcomponent
