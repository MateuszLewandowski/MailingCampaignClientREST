# Wprowadzenie

W ramach zadania zaimplementowano klienta REST oraz przykładowe API. API uruchamiane z wykorzystaniem routingu zawiera komplet metod (GET, POST, PUT, PATCH oraz DELETE), które można wywoływać, gdy w nagłówku rządania zawarty jest api-token (dla implementacji przykładu), wg definicji:

1. Router::get('campaigns', [CampaignController::class, 'index']);
2. Router::get('campaigns/{id}', [CampaignController::class, 'show']);
3. Router::post('campaigns', [CampaignController::class, 'store']);
4. Router::put('campaigns/{id}', [CampaignController::class, 'update']);
5. Router::patch('campaigns/{id}', [CampaignController::class, 'update']);
6. Router::delete('campaigns', [CampaignController::class, 'delete']);

Celem uzyskania JWT, należy przesłać login i hasło na:
1. Router::post('authorize', [AuthController::class, 'authorize']);

W kliencie zaimplementowano trzy metody:
1. getMailingCampaignsList
2. getMailingCampaign
3. createMailingCampaign

## Repozytorium: 
https://github.com/MateuszLewandowski/MailingCampaignClientREST

## Aplikacja
https://merce-task.herokuapp.com/

# Obsługa
1. Plik index.php zawiera wywołanie autoloadera oraz routingu, który z kolei wywołuje odpowiednie metody w kontrolerze.
2. client.php zawiera wywowanie ClientREST, gdzie można testować manualnie zaimplementowane metody.
3. Testy jednostkowe - obsługa testów wybranych kilku funkcjonalności oraz samego klienta, który wykonuje curl'a na index.php celem symulacji zachowania api oraz klienta restowego.

# Klient
Do obsługi klienta zostały wykorzystane:
1. symfony/http-foundation
2. psr/http-message

Dodatkowo wykorzystano apix/log do przykładowej obsługi PSR-3.
Potencjalnie można także doposażyć kod o mechanizm cache'owania PSR-16 np. Redis.

# Testy
W celu sprawdzenia poprawności kodu zostały napisane testy jednostkowe, które pokryły najwrażliwsze elementy aplikacji, tj.:
1. Utworzenie obiektu CampaignDto
2. Wywołanie metod z repozytorium i serwisu Campaign Service & Repository
3. Autoryzacja (login i hasło) + autentykacja JWT
4. Testy - reprezentujące bardziej przypadki użycia - RESTClientCampaignTest, służący do wywołania metod klienta.

# Request lifecycle
1. Inicjalizacja autoloadera, kernel i route w index.php, gdzie Kernel odpowiada wyłącznie za dodanie typu metody rest i uri do globalnego scope'a.
2. Plik route.php wywołuje metody statyczne z klasy Route, przekazując route path i wywołane uri.
3. Route odpowiada za wywołaniej pary kontroler::metoda, dodatkowo zaimplementowano dependency injection dla konstruktora i metod przyjmujących Requesty
4. Requesty wstrzykiwane w konkretne metody odpowiadają za walidację metodą Chain of Responsibility.
5. Kontroler dobiera serwis wg interfejsu (kompozycja). Każda metoda kontrolera wywołuje na potrzeby przykładu jedną metodę z danego serwisu, oczywiście takich wywołań może być więcej w zależności od złożoności operacji. W przypadku większej złożoności aplikacji można zaimplementować np. strategię, która na podstawie dostarczonych przesłanek wstrzyknie odpowiedni obiekt (serwis, repozytorium).
6. Serwis stanowi warstwę odpowiadającą za wywołanie metod z repozytorium. Zasoby przekazywane do serwisu mogą zostać przetworzone według potrzeb, aby odpowiednio je przygotować przed:
A. wysłaniem do bazy danych
B. zwróceniem do kontrolera.
6. Repozytorium moża dla bardziej rozbudowanych rozwiązań zaimplementować w postaci CQRS. W tym przypadku jedna klasa wykonuje operacje oczytu i zapisu.
7. Zwracana jest odpowiedź z wykorzystaniem symfony response
8. W przypadku braku zgodniści URI zwracany jest komunikat 404
