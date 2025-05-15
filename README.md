# Postęp projektu – Biblioteka szkolna

## Tydzień 1
- [x] Strona główna aplikacji z logowaniem i rejestracją  
  _Działa: logowanie (PHP, sesje), rejestracja użytkownika_
- [x] Zaprojektowanie i realizacja bazy danych w phpMyAdmin  
  _Działa: baza z tabelami użytkowników, książek, wypożyczeń_
- [x] Wyświetlanie książek dla bibliotekarzy  
  _Działa: lista książek w panelu admina (`admin/index.php`)_

## Tydzień 2
- [x] Strona edycji danych użytkownika  
  _Działa: `dashboard/settings.php` – zmiana klasy i hasła_
- [x] Strona "Moje wypożyczenia" dla uczniów  
  _Działa: `dashboard/index.php` – lista wypożyczeń i alerty o przetrzymaniu_
- [x] Dodawanie i usuwanie książek (bibliotekarz)  
  _Działa: dodawanie/edycja (`php/upsert.php`), usuwanie (`php/delete.php`)_
- [x] Realizacja wypożyczenia (bibliotekarz)  
  _Działa: przycisk "Wypożycz" w panelu admina, obsługa w `php/borrow.php` (limit wypożyczeń, zmiana dostępności)_
- [x] Alerty o przetrzymanych książkach  
  _Działa: alerty na stronie ucznia (`dashboard/index.php`)_
- [x] Panel przetrzymanych książek dla bibliotekarza (szczegóły i kary)  
  _Działa: tabela w `admin/borrowed.php` (kara 10gr/dzień)_

## Tydzień 3
- [x] Zwracanie książek (bibliotekarz)  
  _Działa: przycisk "Zwróć" w `admin/borrowed.php`, obsługa w `php/zwroc.php`_
- [x] Lista aktualnie wypożyczonych książek (bibliotekarz)  
  _Działa: `admin/borrowed.php`_
- [x] Edycja danych książki (bibliotekarz)  
  _Działa: `php/upsert.php`_
- [x] Statystyki (najczęściej wypożyczana książka, użytkownik z największą liczbą wypożyczeń, liczba przetrzymanych książek)  
  _W `stats.php` uzywam bliblioteki Chart.js aby wyswietlic w ladnym formacie dane_
- [x] Blokada wypożyczeń dla użytkowników z więcej niż 2 przetrzymanymi książkami  
  _Działa: blokada w `php/borrow.php` (limit wypożyczeń)_
- [ ] Własne pomysły i usprawnienia  
  _Brak – do zrobienia_

## Tydzień 4
- [ ] Dokumentacja projektu  
  _Brak – do zrobienia_
- [ ] Prezentacja projektu nauczycielowi  
  _Brak – do zrobienia_

---

## Podsumowanie

- **Działa:** logowanie, rejestracja, lista książek, edycja i usuwanie książek, wypożyczanie i zwracanie książek, lista wypożyczeń, alerty o przetrzymaniu, panel przetrzymań, blokada wypożyczeń, edycja danych użytkownika.
- **Nie działa / brak:** własne usprawnienia, dokumentacja, prezentacja.
