# D3l

D3l est un framework léger qui permet de faire des sites en PHP. Il dispose des fonctionnalités suivantes:
- Middleware
- Moteur de templating
- Routage automatique
- Migration de la base de données
- Gestion de la base de données simplifiée
- Simplification des appels à des API externes
## Middleware

Les middlewares sont des fonctions qui sont exécutées avant ou après une requête.

- Étape 1 : Créez une instance dux middleware

 Le fichier `index.php` à la racine représente le point d'entrée de l'application. On construit une file de middlewares à l'aide de la classe `MiddlewareQueue` et on l'injecte dans l'application.

```php
// Create a middleware queue
$middlewareQueue = new MiddlewareQueue();

// Add middlewares to the queue
$middlewareQueue->addMiddleware(new CorsMiddleware());
$middlewareQueue->addMiddleware(new ExceptionsMiddleware());
$middlewareQueue->addMiddleware(new RoutingMiddleware());

// Handle the request with the middlewares
$response = $middlewareQueue->handle($_REQUEST);
```

- Étape 2 : Créez vos middlewares

Créez des classes qui étendent la classe `Middleware` et implémentez la méthode `handle`. Par exemple, ExceptionsMiddleware ressemble à ceci :

```php
class ExceptionsMiddleware extends Middleware
{
    public function handle($request, $nextMiddleware)
    {
        try { // Try to handle the request with the next middleware
            $response = $nextMiddleware->handle($request);
            return $response;
            
        } catch (RouteNotFoundException $e) { // Catch route not found exceptions
            http_response_code($e->getCode());
        }
        
        catch ( \Exception $e ) { // Catch all other exceptions
            http_response_code(500);
        }
    }
}
```
## Moteur de templating

- Étape 1 : Créez une instance du moteur de template

```php
// Incluez votre classe de moteur de template
require 'Template.php';

// Créez une instance de votre moteur de template
$templateEngine = new Template();
```

- Étape 2 : Assignez des données aux modèles

Utilisez la méthode `assign` pour associer des données aux variables que vous souhaitez afficher dans vos modèles. Par exemple :

```php
$templateEngine->assign('pageTitle', 'Mon site web');
$templateEngine->assign('name', 'John');
```

Ou en passant une variable de contexte au constructeur de la classe

```php
$templateEngine = new Template([
    'pageTitle' => 'Mon site web',
    'name' => 'John'
]);
```

- Étape 3 : Chargez et affichez un modèle

Utilisez la méthode render pour charger et afficher un modèle. Vous pouvez passer le nom du fichier du modèle en argument. Assurez-vous que le fichier existe dans le répertoire de modèles spécifié.

```php
$output = $templateEngine->render('template.html');
```

- Étape 4 : Afficher le résultat

La sortie générée par le moteur de template est stockée dans la variable $output. Vous pouvez l'afficher sur la page web en utilisant echo.

```php
echo $output;
```

- Exemple complet

```php
require 'TemplateEngine.php';

// Créez une instance de votre moteur de template
$templateEngine = new TemplateEngine();

// Assignez des données aux modèles
$templateEngine->assign('pageTitle', 'Mon site web');
$templateEngine->assign('name', 'John');

// Chargez et affichez un modèle
$output = $templateEngine->render('template.html');

// Affichez la sortie générée
echo $output;
```

- Étape 5 : Créez vos modèles

Créez des fichiers HTML avec les placeholders {{ ... }} pour les données que vous avez assignées. Par exemple, template.html pourrait ressembler à ceci :

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ pageTitle }}</title>
</head>
<body>
    <h1>Hello {{ name }}</h1>
</body>
</html>
```
## Routage automatique

Le routage dynamique se fait par le biais d'annotations / attributs. Par exemple:

```php
#[Route('/', name: 'index', methods: ['GET'])]
public function index(){
```

Le premier paramètre est le chemin / URI, le deuxième est le nom et enfin la méthode. Il est possible qu'une route réponde la même chose pour différentes méthodes.

```php
#[Route('/id/{id<\d+>}', name: 'id', methods: ['GET'])]
public function id($param){
```

On peut également donner des `regex` pour donner de quel type doit et va être le paramètre. Dans notre exemple, la valeur doit être un entier, sinon on n'appelle pas la fonction et dans le cas où celle-ci est appelée, alors `$param['id']` sera de type entier.

*Note: Pour l'instant seuls 3 types sont supportés; `integer`,`float`,`string`.*

En cas de route non trouvée, une exeception est levée dans le middleware `RoutingMiddleware` et est attrapée par le middleware `ExceptionsMiddleware` qui renvoie une erreur 404.

Il est possible de modifier la page d'erreur 404 en modifiant le fichier `404.html` dans le dossier `templates`.

## Simplification des appels à des API externes
## Migration de la base de données
## Gestion de la base de données simplifiée