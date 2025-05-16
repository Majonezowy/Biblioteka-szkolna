## Instalacja

1. Sklonuj repozytorium:

    ```bash
    git clone https://github.com/Majonezowy/Biblioteka-szkolna.git
    ```

2. Zaimportuj bazę danych z pliku `biblioteka.sql` do swojego serwera MySQL.

3. Skonfiguruj połączenie z bazą danych w pliku `php/db.php`.

4. Uruchom aplikację na lokalnym serwerze WWW (np. XAMPP, WAMP, Laragon).

<details>
  <summary><strong>📚 Postęp projektu – Biblioteka szkolna</strong></summary>

  <h2>Tydzień 1</h2>
  <ul>
    <li>[x] Strona główna aplikacji z logowaniem i rejestracją  
      <br><em>Działa: logowanie (PHP, sesje), rejestracja użytkownika</em></li>
    <li>[x] Zaprojektowanie i realizacja bazy danych w phpMyAdmin  
      <br><em>Działa: baza z tabelami użytkowników, książek, wypożyczeń</em></li>
    <li>[x] Wyświetlanie książek dla bibliotekarzy  
      <br><em>Działa: lista książek w panelu admina (<code>admin/index.php</code>)</em></li>
  </ul>

  <h2>Tydzień 2</h2>
  <ul>
    <li>[x] Strona edycji danych użytkownika  
      <br><em>Działa: <code>dashboard/settings.php</code> – zmiana klasy i hasła</em></li>
    <li>[x] Strona "Moje wypożyczenia" dla uczniów  
      <br><em>Działa: <code>dashboard/index.php</code> – lista wypożyczeń i alerty o przetrzymaniu</em></li>
    <li>[x] Dodawanie i usuwanie książek (bibliotekarz)  
      <br><em>Działa: dodawanie/edycja (<code>php/upsert.php</code>), usuwanie (<code>php/delete.php</code>)</em></li>
    <li>[x] Realizacja wypożyczenia (bibliotekarz)  
      <br><em>Działa: przycisk "Wypożycz" w panelu admina, obsługa w <code>php/borrow.php</code> (limit wypożyczeń, zmiana dostępności)</em></li>
    <li>[x] Alerty o przetrzymanych książkach  
      <br><em>Działa: alerty na stronie ucznia (<code>dashboard/index.php</code>)</em></li>
    <li>[x] Panel przetrzymanych książek dla bibliotekarza (szczegóły i kary)  
      <br><em>Działa: tabela w <code>admin/borrowed.php</code> (kara 10gr/dzień)</em></li>
  </ul>

  <h2>Tydzień 3</h2>
  <ul>
    <li>[x] Zwracanie książek (bibliotekarz)  
      <br><em>Działa: przycisk "Zwróć" w <code>admin/borrowed.php</code>, obsługa w <code>php/zwroc.php</code></em></li>
    <li>[x] Lista aktualnie wypożyczonych książek (bibliotekarz)  
      <br><em>Działa: <code>admin/borrowed.php</code></em></li>
    <li>[x] Edycja danych książki (bibliotekarz)  
      <br><em>Działa: <code>php/upsert.php</code></em></li>
    <li>[x] Statystyki (najczęściej wypożyczana książka, użytkownik z największą liczbą wypożyczeń, liczba przetrzymanych książek)  
      <br><em>W <code>stats.php</code> używam biblioteki Chart.js aby wyświetlić dane</em></li>
    <li>[x] Blokada wypożyczeń dla użytkowników z więcej niż 2 przetrzymanymi książkami  
      <br><em>Działa: blokada w <code>php/borrow.php</code> (limit wypożyczeń)</em></li>
    <li>[ ] Własne pomysły i usprawnienia  
      <br><em>Brak – do zrobienia</em></li>
  </ul>

  <h2>Tydzień 4</h2>
  <ul>
    <li>[x] Dokumentacja projektu  
      <br><em>Brak – do zrobienia</em></li>
    <li>[ ] Prezentacja projektu nauczycielowi  
      <br><em>Brak – do zrobienia</em></li>
  </ul>

  <hr>

  <h2>Podsumowanie</h2>
  <ul>
    <li><strong>Działa:</strong> logowanie, rejestracja, lista książek, edycja i usuwanie książek, wypożyczanie i zwracanie książek, lista wypożyczeń, alerty o przetrzymaniu, panel przetrzymań, blokada wypożyczeń, edycja danych użytkownika.</li>
    <li><strong>Nie działa / brak:</strong> własne usprawnienia, dokumentacja, prezentacja.</li>
  </ul>

</details>
