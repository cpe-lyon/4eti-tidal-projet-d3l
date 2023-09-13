# D3l
D3l est un framework léger qui permet de faire des sites en PHP. Il dispose des fonctionnalités suivantes:
- moteur de templating
- migration de la base de données
- gestion de la base de données simplifiée
- routage automatique
- simplification des appels à des API externes

## Moteur de templating

## Migration de la base de données

## Gestion de la base de données simplifiée

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
## Simplificqtion des appels à des API externes