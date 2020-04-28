# Сниппет pageBuilderToEvoSearch

Сниппет предназначен для индексации блоков Page Builder в evoSearch.

### Установка:
1. Прописать название сниппета "pageBuilderToEvoSearch" в параметр prepare плагина evoSearch.
2. Проверить, чтоб в порядоке вызова плагинов на событие OnDocFormSave evoSearch был после PageBuilder.
3. Переиндексировать весь поиск.


### Конфигурация cниппета:  
**Index PageBuilder In Templates** - список шаблонов, через запятую, для которых будут индексироваться блоки PageBuilder.
По умолчанию пусто, то есть все документы.  

**Index Only Allowed** - индексировать только разрешенные поля.   
Если стоит **yes**, то для попадания значения поля в индекс, в конфигурации PageBuilder в поле необходимо добавить ```'evoSearchIndex'=>true```  
```php
return [
    'fields' => [
        'text1' => [
            'caption' => 'Text',
            'type'    => 'text',
            'evoSearchIndex'=>true
        ]
    ]
];
```