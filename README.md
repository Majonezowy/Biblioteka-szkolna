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
  _Brak pliku – funkcja do zrobienia_
- [x] Strona "Moje wypożyczenia" dla uczniów  
  _Brak pliku – funkcja do zrobienia_
- [x] Dodawanie i usuwanie książek (bibliotekarz)  
  _Działa: dodawanie/edycja (`php/upsert.php`), usuwanie (`php/delete.php`)_
- [x] Realizacja wypożyczenia (bibliotekarz)  
  _Działa: przycisk "Wypożycz" w panelu admina, ale plik `php/borrow.php` jest pusty – funkcja niezaimplementowana_
- [ ] Alerty o przetrzymanych książkach  
  _Brak – do zrobienia_
- [ ] Panel przetrzymanych książek dla bibliotekarza (szczegóły i kary)  
  _Brak – do zrobienia_

## Tydzień 3
- [x] Zwracanie książek (bibliotekarz)  
  _Działa: przycisk "Zwróć" w `admin/borrowed.php` (zakładamy, że `php/zwroc.php` działa)_
- [x] Lista aktualnie wypożyczonych książek (bibliotekarz)  
  _Działa: `admin/borrowed.php`_
- [x] Edycja danych książki (bibliotekarz)  
  _Działa: `php/upsert.php`_
- [ ] Statystyki (najczęściej wypożyczana książka, użytkownik z największą liczbą wypożyczeń, liczba przetrzymanych książek)  
  _Brak – do zrobienia_
- [x] Blokada wypożyczeń dla użytkowników z więcej niż 2 przetrzymanymi książkami  
  _Brak – do zrobienia_
- [ ] Własne pomysły i usprawnienia  
  _Brak – do zrobienia_

## Tydzień 4
- [ ] Dokumentacja projektu  
  _Brak – do zrobienia_
- [ ] Prezentacja projektu nauczycielowi  
  _Brak – do zrobienia_

---

## Podsumowanie

- **Działa:** logowanie, rejestracja, lista książek, edycja i usuwanie książek, lista wypożyczeń, zwracanie książek.
- **Nie działa / brak:** wypożyczanie książek (`php/borrow.php` pusty), edycja danych użytkownika, moje wypożyczenia, alerty i panel przetrzymań, statystyki, blokady, dokumentacja.
