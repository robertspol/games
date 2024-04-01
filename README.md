# Gry

Aplikacja stworzona w języku PHP i zawierająca 2 gry: Anioł czy diabeł oraz Kolorowa ruletka.

## Jak zacząć

Aby uruchomić ten projekt na swoim lokalnym komputerze, wykonaj następujące kroki:

1.Zainstaluj pakiet XAMPP na swoim komputerze.
2.Uruchom plik xampp-control i włącz serwer Apache oraz MySQL.
3.Pobierz katalog z projektem do folderu htdocs w katalogu, w którym zainstalowany został XAMPP`.
4.Otwórz przeglądarkę internetową i przejdź do http://localhost/games, aby korzystać z aplikacji.

## Sposób użycia
1. Uruchom aplikację.
2. Utwórz nowe konto, wprowadzając wymagane dane.
3. Zaloguj się na swoje konto.
4. Wybierz grę.

### Zasady gier

#### Anioł czy diabeł

Po załadowaniu gry kliknij w przycisk "Let's play", a następnie w jedną z trzech postaci. Pamiętaj, że anioł pokona diablicę, diablica czeka choćby na wątpliwości, a wątpliwości wygrają z aniołem... Pod postaciami podana jest punktacja i inne dane. Grać można do nieskończonej ilości wygranych.

#### Kolorowa ruletka

Po załadowaniu gry podaj stawkę w małym białym polu, a następnie kliknij w przycisk "Graj". Zostaną wylosowane kolory dla 4 pól. Poniżej podane są różne scenariusze i ich konsekwencje:
- Jeśli wszystkie pola otrzymają ten sam kolor, wówczas uzyskasz wybraną stawkę pomnożoną przez 10.
- Jeśli wylosowane zostaną 2 pary kolorów, ale nieułożone po przekątnej, na Twoje konto przybędzie podana stawka pomnożona przez 5.
- W przypadku pojawienia się jednej z takich par, zyskasz po prostu podaną stawkę.

Jeśli żaden z tych scenariuszy się nie wydarzy, stracisz tyle, ile zaryzykowałeś. Nie można podać stawki wyższej od stanu posiadania, a gdy wszystkie pieniądze na koncie zostaną utracone, gra się kończy.
