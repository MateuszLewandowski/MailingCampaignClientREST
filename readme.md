## Wprowadzenie

API zawiera komplet metod (GET, POST, PUT, PATCH, DELETE).
Klient wykonuje dwie metody:
1. getMailingCampaignsList
2. getMailingCampaign

## Obsługa
1. Plik index.php zawiera wywołanie autoloadera oraz routingu, który z kolei wywołuje odpowiednie metody na kontrolerze.
2. client.php zawiera wywowanie ClientREST, gdzie można testować manualnie zaimplementowane metody.
3. Testy jednostkowe - obsługa testów wybranych kilku funkcjonalności oraz samego klienta, który wykonuje curl'a na index.php celem symulacji zachowania api oraz klienta restowego.

## Klient
Do obsługi klienta zostały wykorzystane:
1. symfony/http-foundation
2. psr/http-message

Dodatkowo wykorzystano apix/log do przykładowej obsługi PSR-3.
Potencjalnie można także doposażyć kod o mechanizm cache'owania PSR-16.

## Request lifecycle
1. Inicjalizacja autoloadera, kernel i route w index.php, gdzie Kernel odpowiada wyłącznie za dodanie typu metody rest i uri do globalnego scope'a.
2. Plik route.php wywołuje metody statyczne z klasy Route, przekazując route path i wywołane uri.
3. Route odpowiada za wywołaniej pary kontroler::metoda, dodatkowo zaimplementowano dependency injection dla konstruktora i metod przyjmujących Requesty
4. Requesty wstrzykiwane w konkretne metody odpowiadają za walidację metodą Chain of Responsibility.
5. Kontroler agreguje serwis po interfejsie (kompozycja). Każda metoda kontrolera wywołuje na potrzeby przykładu jedną metodę z danego serwisu, oczywiście takich wywołań może być więcej w zależności od złożoności operacji. W przypadku większej złożoności aplikacji można zaimplementować np. strategię, która na podstawie dostarczonych przesłanek wstrzyknie odpowiedni obiekt.
6. Serwis stanowi warstwę odpowiadającą za wywołanie metod z repozytorium. Zasoby przekazywane do serwisu mogą zostać przetworzone według potrzeb, aby odpowiednio je przygotować przed:
A. wysłaniem do bazy danych
B. zwróceniem do kontrolera.
6. Repozytorium moża dla bardziej rozbudowanych rozwiązań zaimplementować w postaci CQRS. W tym przypadku jedna klasa wykonuje operacje oczytu i zapisu.

