<?php

return [
    'login' => 'Bejelentkezés',
    'password' => 'Jelszó',
    'logout' => 'Kijelentkezés',
    'notLanguage' => 'Nincs feltöltve nyelv',
    'notPermission' => [
        'title' => 'Rendszerüzenet',
        'text' => 'Nincs jogosultságod'
    ],
    'auth' => [
        'ban' => 'A megadott felhasználó ki lett tiltva 24 órára a túl sok próbálkozás miatt',
        'wrong' => 'Az e-mail vagy a jelszó helytelen!',
    ],
    'profile' => [
        'title'=>'Profil',
        'edit'=>'Profil szerkesztése',
        'password' => 'Jelszó',
        'password2' => 'Jelszó ismét',
        'tutorial' => 'Segítségek bekapcsolása',
        'complete' => [
            'tutorial' => 'Végrehajtott segítségek'
        ],
    ],

    'change_password' => [
        'title' => 'Jelszó megváltoztatása',
        'btn' => 'Tovább',
        'alerts' => [
            'old_password' => 'Az új jelszó nem változott. Kérjük adjon meg egy másik jelszót'
        ]
    ],

    'btn' => [
        'new' => 'Új',
        'edit' => 'Szerkesztés',
        'ban' => 'Tiltás feloldása',
        'delete' => 'Törlés',
        'cancel' => 'Mégse',
        'forceDelete' => 'Végleges törlés',
        'again' => 'Visszatöltés',
        'trash' => 'Lomtár',
        'back' => 'Vissza',
        'save' => 'Mentés',
        'saveClose' => 'Mentés és bezár',
        'saveArchive' => 'Aktíválás',
        'saveCloseArchive' => 'Aktíválás és bezár',
        'saveNew' => 'Mentés és új',
        'no' => 'Nem',
        'yes' => 'Igen',
        'order' => 'Sorrend mentése',
        'active' => 'Aktív',
        'inactive' => 'Inaktív',
        'filter' => 'Szűrés',
        'sort' => 'Rendezés',
        'sort_off' => 'Rendezés kikapcsolása',
        'trans' => 'Fordítás',
        'export' => 'Export',
        'close' => 'Bezár',
        'preview' => 'Előnézet',
        'show' => 'Megtekintés',
        'more' => 'Bővebben',
        'next' => 'Tovább',
        'featured' => 'Kiemelés',
        'publishLang' => 'Nyelvesítés frissítése',
        'productsRefresh' => 'Termékek frissítése',
        'documents' => 'Dokumentumok',
        'xml' => 'XML feltöltése',
        'select' => 'Kijelölés',
        'status' => 'Státusz',
    ],

    'alert' => [
        'token' => 'Sajnos nem tudjuk elfogadni a kérést. Kérjük, próbálja meg újra',
        'required' => 'Kérjük, töltse ki ezt a mezőt',
        'regex' => 'Kérjük, tartsa magát a kívánt formátumhoz',
        'email' => 'Az e-mail cím nem megfelelő formátumú.',
        'password_confirmed' => 'A két jelszó nem egyezik',
        'min' => 'Minimum :c karakternek kell lenni-e',
        'save' => 'Sikeresen elmentve!',
        'savePublish' => 'Sikeresen frissítve!',
        'delete' => 'Sikeresen kitörölve!',
        'noimage' => 'Nincs kiválasztva kép!',
        'nofile' => 'Nincs kiválasztva fájl!',
        'mimes' => 'Nem megfelelő a fájl formátuma',
        'error_status' => 'Nem sikerült a státusz változtatás!',
        'success_status' => 'Sikeres státusz változtatás!',
        'no_change_order' => 'Nem változott a sorrend!',
        'delete_restore' => 'Sikeresen visszaállítva!',
        'delete_force' => 'Véglegesen kitörölve!',
        'size' => 'A fájl mérete túl nagy',
        'have' => 'Ezen a néven már létezik fájl',
        'haveError' => 'Hibás űrlapkitöltés',
        'password_regex' => 'A jelszónak kisbetűből, nagybetűből, számból és ékezetnélküli karakterekből kell állnia. Minimum 5 karakter. Használható speciális karakterek: %_',
    ],

    'system' => [
        'title' => 'Rendszer',
    ],

    'xml' => [
        'errors' => 'A feltöltés során hiányzó elemeket találtunk',
    ],

    'archived' => [
        'current' => 'Aktív',
    ],

    'info' => [
        'deleteFile' => 'A fájl mentés után törlődik',
        'created_at' => 'tól-ig időt | jellel válasszuk el pl: 2016-08|2016-08-20',
    ],

    'slim' => [
        'title' => 'Húzd ide a képet vagy kattints ide a kép kiválasztásához',
        'info' => 'Kiterjesztések: :ext<br>Méret: maximum 6MB',
        'info2' => 'Vágási méret: :size',
        'cancel' => 'Bezár',
        'confirm' => 'Mentés',
        'small' => 'A fájl túl kicsi, minimum méret: :size',
        'vertical' => 'Állókép',
        'horizontal' => 'Fekvőkép',
        'error' => [
            'browser' => 'Az ön böngészője nem támogatja a kép szerkesztését',
            'type' => 'Nem engedélyezett a fájl kiterjesztése',
            'size' => 'A fájl mérete túl nagy, maximum: $0 MB lehet',
        ],
    ],
    'modal_delete' => [
        'head' => 'Figyelem!',
        'body' => 'Bizotsan ki akarod törölni?',
    ],

    'trash' => [
        'title'=>'Lomtár',
        'not'=>'Nincs törölt elem',
    ],
    'ajax' => [
        'errors' => 'Sikertelen feltöltés',
        'success' => 'Sikeres feltöltés',
        'error'=>'Kérjük, próbálja meg később.',
    ],
    'day' => [
        'mon' => 'Hétfő',
        'tue' => 'Kedd',
        'wed' => 'Szerda',
        'thu' => 'Csütörtök',
        'fri' => 'Péntek',
        'sat' => 'Szombat',
        'sun' => 'Vasárnap',
    ],
    'caches' => [
        'title' => 'Gyorsítótár',
        'permission' => 'Gyorsítótár kezelő'
    ],
    'dashboard' => [
        'title'=>'Vezérlőpult',
        'active' => 'Felhasználó az oldalon',
        'new_users' => 'Új felhasználó ma',
        'return_users' => 'Visszatérő felhasználó',
        'all_users' => 'Összes felhasználó',
        'all_show' => 'Összes megtekintés',
        'start' => 'Statisztika kezdete',
        'end' => 'Statisztika vége',
        'chart' => [
            'new_user' => 'Felhasználók az oldalon',
            'device' => 'Eszközök',
            'browser' => 'Böngészők',
            'top' => 'Top 10 oldal megtekintés',
        ],
        'device' => [
            'computer' => 'Számítógép',
            'tablet' => 'Tablet',
            'mobile' => 'Mobil',
        ]
    ],
    'languages' => [
        'title' => 'Nyelvkezelő',
        'permission' => 'Nyelvkezelő',
        'new' => 'Új nyelv',
        'edit' => 'Nyelv szerkesztése',
        'table' => [
            'name' => 'Nyelv',
            'locale' => 'Nyelv kódja',
        ],
        'form' => [
            'name' => 'Nyelv',
            'locale' => 'Nyelv kódja',
        ],
        'alerts' => [
            'have' => 'Már létezik ez a nyelv',
            'notfound' => 'Nincs találat',
        ]
    ],
    'translates' => [
        'title' => 'Szöveg fordítások',
        'edit' => 'Szöveg szerkesztése',
        'table' => [
            'name' => 'Azonosító',
            'text' => 'Szöveg',
        ],
        'form' => [
            'item' => 'Azonosító'
        ]
    ],
    'pages' => [
        'title' => 'Oldalak',
        'permission' => 'Odalkezelő',
        'new' => 'Új oldal',
        'edit' => 'Oldal szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Oldal',
            'lang' => 'Nyelv',
            'created_at' => 'Létrehozva',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'slug' => 'Keresőbarát cím',
            'content' => 'Tartalom',
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Ez az oldal már létezik!',
        ],
    ],
    'feed_categories' => [
        'title' => 'Cikk kategóriák',
        'permission' => 'Cikk kategóriakezelő',
        'new' => 'Új kategória',
        'edit' => 'Kategória szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'slug' => 'Keresőbarát cím',
            'image' => 'Kép',
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már létezik ez a kategória',
        ],
    ],
    'feed_labels' => [
        'title' => 'Címkék',
        'permission' => 'Címkekezelő',
        'new' => 'Új címke',
        'edit' => 'Címke szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'slug' => 'Keresőbarát cím',
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már létezik ez a címke',
        ],
    ],
    'feed_items' => [
        'main' => 'Cikkek',
        'title' => 'Cikkek',
        'permission' => 'Cikk kezelő',
        'new' => 'Új cikk',
        'edit' => 'Cikk szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'throneCategories' => [
                'title' => 'Kategória',
                'all' => 'Mind',
            ],
            'throneLabels' => [
                'title' => 'Címke',
                'all' => 'Mind',
            ],
            'active_at' => 'Aktiválás',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'slug' => 'Keresőbarát cím',
            'content' => 'Tartalom',
            'short' => 'Bevezető',
            'image' => 'Kép',
            'bgimage' => 'Háttérkép',
            'category' => [
                'title' => 'Kategóriák',
                'placeholder' => 'Kategóriák kiválasztása'
            ],
            'label' => [
                'title' => 'Címkék',
                'placeholder' => 'Címke kiválasztása'
            ],
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már létezik ez a cikk',
        ],
    ],
    'partner_categories' => [
        'title' => 'Partner kategóriák',
        'permission' => 'Partner kategóriakezelő',
        'new' => 'Új kategória',
        'edit' => 'Kategória szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'slug' => 'Keresőbarát cím',
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már létezik ez a kategória',
        ],
    ],
    'partner_items' => [
        'main' => 'Partnerek',
        'title' => 'Partnerek',
        'permission' => 'Partnerkezelő',
        'new' => 'Új partner',
        'edit' => 'Partner szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'category' => [
                'title' => 'Kategória',
                'all' => 'Mind',
            ],
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'image' => 'Kép',
            'url' => 'Link',
            'target' => [
                'title' => 'Link megnyitása',
                '0' => 'Saját ablakban',
                '1' => 'Új ablakban',
            ],
            'category' => [
                'title' => 'Kategóriák',
                'placeholder' => 'Kategóriák kiválasztása'
            ],
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már létezik ez a partner',
        ],
    ],
    'fixedcontent' => [
        'title' => 'Fix tartalmak',
        'permission' => 'Fix tartalomkezelő',
        'edit' => 'Fix tartalom szerkesztése',
        'table' => [
            'title' => 'Megnevezés',
        ],
        'form' => [
            'title' => 'Megnevezés',
            'content' => 'Tartalom',
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
        ],
    ],
    'emails' => [
        'title' => 'Emailek',
        'permission' => 'Email kezelő',
        'edit' => 'Email szerkesztése',
        'table' => [
            'title' => 'Megnevezés',
        ],
        'form' => [
            'title' => 'Megnevezés',
            'subject' => 'Tárgy',
            'content' => 'Tartalom',
            'codes' => 'Elhelyezhető kódok',
            'code' => 'Kódok',
            'desc' => 'Leírás',
            'shortcode' => [
                'lastname' => 'Vezetéknév',
                'firstname' => 'Keresztnév',
                'name' => 'Név',
                'email' => 'Email cím',
                'phone' => 'Telefonszám',
                'login_url' => 'Bejelentkezéshez az url',
                'password' => 'Felhasználó jelszava',
                'password_reminder_link' => 'Jelszó emlékeztető link',
            ],
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
        ],
    ],
    'redirects' => [
        'title' => 'Átirányítások',
        'permission' => 'Átirányítás kezelő',
        'new' => 'Új átirányítás',
        'edit' => 'Átírányítás szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'old' => 'Régi link',
            'new' => 'Új link',
        ],
        'form' => [
            'old' => 'Régi link',
            'new' => 'Új link',
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
        ],
    ],
    'slider' => [
        'title' => 'Slider',
        'permission' => 'Slider kezelő',
        'new' => 'Új slider',
        'edit' => 'Slider szerkesztése',
        'text' => 'Szöveg elhelyezkedése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Megnevezés',
            'lang' => 'Nyelv',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Megnevezés',
            'button' => 'Gomb címe (ha kell gomb)',
            'link' => 'Link',
            'target' => [
                'title' => 'Link megnyitása',
                'self' => 'Saját ablakban',
                'new' => 'Új ablakban',
            ],
            'type' => [
                'title' => 'Slider típusa',
                'image' => 'Kép',
                'video' => 'Videó',
            ],
            'shortdesc' => 'Szöveg',
            'content' => 'Tartalom',
            'title2' => 'Megejelenő cím',
            'max' => 'maximum 200 karakter',
            'publicstart' => 'Megjelenés kezdete',
            'publicend' => 'Megjelenés vége',
            'image' => 'Kép',
            'text' => [
                'color' => 'Szöveg színe',
                'bgColor' => 'Doboz háttérszíne',
                'image' => 'A képre kattintva tudjuk a doboz elhelyezkedését beállítani',
            ]
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
        ],
    ],
    'menu' => [
        'title' => 'Menükezelő',
        'permission' => 'Menükezelő',
        'main' => 'Fő menü',
        'side' => 'Oldalsó menü',
        'footer' => 'Lábléc menü',
        'new' => 'Új menü',
        'edit' => 'Menü szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'link' => 'Link',
            'image' => 'Kép',
            'linktype' => [
                'title' => 'Link típusa',
                'manual' => 'Manuális',
                'content' => 'Tartalmi oldal',
                'feeds' => 'Cikkek',
                'feed_category' => 'Cikk kategória',
                'feed_item' => 'Cikk',
                'feed_label' => 'Címke',
            ],
            'content' => [
                'link' => 'Tartalom',
                'choose' => 'Tartalom kiválasztása',
            ],
            'feed_category' => [
                'link' => 'Cikk kategóriák',
                'choose' => 'Cikk kategória kiválasztása',
                'all' => 'Összes',
            ],
            'feed_label' => [
                'link' => 'Címkék',
                'choose' => 'Címke kiválasztása'
            ],
            'feed_items' => [
                'link' => 'Cikkek',
                'choose' => 'Cikk kiválasztása',
            ],
            'desc' => 'Leírás',
            'button' => 'Gomb szövege',
            'main' => 'Főoldal?',
            'newpage' => [
                'title' => 'Link megnyitása',
                0 => 'Aktuális ablakban',
                1 => 'Új ablakban',
            ],
        ]
    ],
    'mediatar' => [
        'title' => 'Médiatár',
    ],
    'settings' => [
        'title' => 'Beállítások',
        'permission' => 'Oldalbeállítás',
        'edit' => 'Beállítások szerkesztése',
        'menu' => [
            'seo' => 'SEO',
            'cookie' => 'Cookie',
            'social' => 'Közösség',
            'tracking' => 'Nyomkövetés',
            'service' => 'Karbantartás',
            'upload' => 'Feltöltések',
            'other' => 'Egyéb',
            'javascript' => 'Javascript',
        ],
        'form' => [
            'facebook' => 'Facebook link',
            'youtube' => 'Youtube link',
            'instagram' => 'Instagram link',
            'linkedin' => 'Linkedin link',
            'google' => 'Google Plus link',
            'twitter' => 'Twitter link',
            'ga' => 'Google Analytics követőkód',
            'ga4' => 'Google Analytics 4 követőkód',
            'gtm' => 'Google Tag Manager követőkód',
            'pixel' => 'Facebook pixelkód',
            'javascript' => 'Javascript-ek a &#60;head&#62;&#60;/head&#62; közé',
            'seo' => [
                'title' => 'SEO cím',
                'keywords' => 'SEO kulcsszavak',
                'desc' => 'SEO leírás',
                'max' => 'max. 160 karakter',
            ],
            'cookie' => [
                'title' => 'Cookie cím',
                'desc' => 'Cookie szöveg',
                'btn' => 'Bővebben gomb szövege',
                'link' => 'Bővebben gomb linkje',
                'ok' => 'Rendben gomb szövege',
                'disable' => 'Elutasítás gomb szövege',
                'delete_cookie' => 'Süti törlés gomb szövege',
            ],
            'social' => [
                'header' => 'Közösségi linkek',
                'select' => 'Közösségi oldalak',
            ],
            'service' => [
                'header' => 'Karbantartás',
                'welcome' => 'Üdvözlő szöveg',
            ],
            'upload' => [
                'image' => 'Kép feltöltésének a limitje. Max: 700MB',
                'document' => 'Dokumentum feltöltésének a limitje. Max: 700MB',
                'video' => 'Videó feltöltésének a limitje. Max: 700MB',
            ],
            'other' => [
                'map' => 'Google térkép API kulcs',
            ],
        ]
    ],
    'search' => [
        'title' => 'Keresés',
        'permission' => 'Keresési statisztika',
        'table' => [
            'id' => 'Azonosító',
            'key' => 'Kulcsszó',
            'created_at' => 'Létrehozva',
            'hits' => 'Keresések',
            'hit_now' => 'Mai keresés',
        ],
        'form' => [

        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
        ],
    ],
    'documents' => [
        'title' => 'Dokumentumok',
        'manager' => 'Dokumentumok',
        'download' => 'Letöltések száma',
        'extension' => 'Kiterjesztés',
        'size' => 'Méret',
        'folder' => 'Mappa',
        'new_folder' => 'mappa',
        'new_file' => 'dokumentum',
        'add' => 'hozzáadás',
        'export' => 'letöltés',
        'paste' => 'beillesztés',
        'form' => [
            'title' => 'Név',
            'file' => 'Fájl kiválasztása',
            'image' => 'Kép feltöltése',
            'ifnoimage' => 'Ha nincs kép akkor az ikon jelenik meg',
        ],
        'alerts' => [
            'have' => 'Már létezik ez a dokumentum ebben a kategóriában',
            'empty' => 'A mappa üres',
        ]
    ],
    'documentcategory' => [
        'title' => 'Mappák',
        'permission' => 'Dokumentum kategóriakezelő',
        'new' => 'Új mappa',
        'edit' => 'Mappa szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'shortcode' => 'Shortcode',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'slug' => 'Keresőbarát cím',
            'image' => 'Mappa kép',
        ],
        'alerts' => [
            'not' => 'Nincs ilyen mappa. Kérjük, töltse újra az oldalt vagy lépjen vissza egy mappát.',
            'have' => 'Ebben a mappában már létezik ez a mappa',
        ]
    ],
    'documentitem' => [
        'title' => 'Dokumentumok',
        'permission' => 'Dokumentumkezelő',
        'new' => 'Új dokumentum',
        'edit' => 'Dokumentum szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Név',
            'shortcode' => 'Shortcode',
            'download' => 'Letöltések száma',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Név',
            'file' => 'Fájl kiválasztása',
            'image' => 'Kép feltöltése',
            'ifnoimage' => 'Ha nincs kép akkor az ikon jelenik meg',
        ],
        'alerts' => [
            'not' => 'Nincs ilyen fájl. Kérjük, töltse újra az oldalt vagy lépjen vissza egy mappát.',
            'have' => 'Már létezik ez a dokumentum ebben a kategóriában',
        ]
    ],

    'gallery' => [
        'title' => 'Galériák',
        'permission' => 'Galériakezelő',
        'new' => 'Új mappa',
        'edit' => 'Mappa szerkesztése',
        'extension' => 'Kiterjesztés',
        'folder' => 'Mappa',
        'new_folder' => 'mappa',
        'new_file' => 'kép',
        'paste' => 'beillesztés',
        'add' => 'hozzáadás',
        'export' => 'letöltés',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Név',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Név',
            'slug' => 'Keresőbarát cím',
            'image' => 'Album kép',
        ],
        'alerts' => [
            'not' => 'Nincs ilyen mappa. Kérjük, töltse újra az oldalt vagy lépjen vissza egy mappát.',
        ]
    ],
    'galleryimages' => [
        'title' => 'Képek',
        'permission' => 'Képkezelő',
        'new' => 'Új kép',
        'edit' => 'Kép szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Név',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Név',
            'alt' => 'Kép szövege',
            'image' => 'Kép',
        ],
        'alerts' => [
            'not' => 'Nincs ilyen fájl. Kérjük, töltse újra az oldalt vagy lépjen vissza egy mappát.',
            'have' => 'Már létezik ez a kép ebben a kategóriában',
        ]
    ],

    'videogallery' => [
        'title' => 'Videókezelő',
        'permission' => 'Videó kategóriakezelő',
        'new' => 'Új mappa',
        'edit' => 'Mappa szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Név',
            'shortcode' => 'Shortcode',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Név',
            'slug' => 'Keresőbarát cím',
            'image' => 'Album kép',
        ],
        'alerts' => [
            'not' => 'Nincs ilyen mappa. Kérjük, töltse újra az oldalt vagy lépjen vissza egy mappát.',
        ]
    ],
    'videoitem' => [
        'title' => 'Videók',
        'permission' => 'Videó kezelő',
        'new' => 'Új videó',
        'edit' => 'Videó szerkesztése',
        'type' => [
            'title' => 'Típus',
            '1' => 'Youtube',
            '2' => 'Vimeo',
            '3' => 'HTML5',
        ],
        'folder' => 'Mappa',
        'new_folder' => 'mappa',
        'new_file' => 'videó',
        'add' => 'hozzáadás',
        'paste' => 'beillesztés',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Név',
            'shortcode' => 'Shortcode',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Név',
            'slug' => 'Keresőbarát cím',
            'videotype' => [
                'title'=>'Videó típusa',
                'youtube'=>'Youtube',
                'vimeo'=>'Vimeo',
                'custom'=>'HTML5 videó',
                'gif'=>'GIF',
                'sound'=>'Hang',
            ],
            'youtube_id' => 'Youtube azonosító (https://www.youtube.com/watch?v=<span class="featured">valami</span>)',
            'vimeo_id' => 'Vimeo azonosító (https://vimeo.com/<span class="featured">valami</span>)',
            'image' => 'Kép feltöltése',
            'ifnoimage' => 'Ha nincs kép akkor az ikon jelenik meg',
            'autoplay' => 'Automatikus lejátszás',
            'loop' => 'Ismétlés',
            'mute' => 'Hang',
        ],
        'alerts' => [
            'have' => 'Már van ilyen videó ebben a mappában'
        ],
    ],
    'admins' => [
        'main' => 'Admin',
        'title' => 'Felhasználók',
        'permission' => 'Felhasználó kezelő',
        'users' => 'Felhasználok',
        'table' => [
            'name' => 'Név',
            'email' => 'E-mail',
            'permission' => 'Jogosultság',
        ],
        'data' => [
            'emailData' => 'Hozzáférést kaptál erre az oldalra:<br>
                                        :link
                                        <br><br>
                                        Adatok:<br>
                                        Felhasználó: :email<br>
                                        Jelszó: :password<br>',
            'subject' => 'Hozzáférés',
        ],
        'new' => 'Új felhasználó',
        'edit' => 'Felhasználó szerkesztése',
        'notuser' => 'Még nincs feltöltve felhasználó',
        'form' => [
            'name' => 'Név',
            'email' => 'E-mail',
            'password' => 'Jelszó',
            'password2' => 'Jelszó ismét',
            'permission' => 'Jogosultság',
            'generate' => 'Jelszó generálása',
            'send_email' => 'Adatok kiküldése az e-mail címre',
            'tutorial' => 'Segítség bekapcsolása',
            'first_login' => 'Jelszó megváltoztatása bejelentkezéskor'
        ],
        'alerts' => [
            'exists' => 'Ez a felhasználó már létezik',
            'ban' => 'Tiltás feloldva',
        ]
    ],

    'permissions' => [
        'title' => 'Jogosultságok',
        'permission' => 'Jogosultságkezelő',
        'new' => 'Új jogosultság',
        'edit' => 'Jogosultság szerkesztése',
        'table' => [
            'title' => 'Megnevezés',
        ],
        'form' => [
            'name' => 'Megnevezés',
            'all' => 'Mind kijelölése',
            'read' => 'Megtekintés',
            'new' => 'Létrehozás',
            'edit' => 'Szerkesztés',
            'export' => 'Export',
            'show' => 'Megtekintés',
            'delete' => 'Törlés',
            'upload' => 'Feltöltés',
            'text' => 'Szöveg fordítás',
            'publish' => 'Frissítés',
            'trash' => 'Lomtár',
        ],
        'alerts' => [
            'have' => 'Ez a jogosultság már létezik',
        ]
    ],
    'widget' => [
        'title' => 'Widgetek',
        'permission' => 'Widget kezelő',
        'edit' => 'Widget szerkesztése',
        'new' => 'Új widget',
        'default_title' => 'Megnevezés',
        'menu' => [
            'default' => 'Alapadatok',
            'style' => 'Design'
        ],
        'style' => [
            'min_height' => 'Minimum magasság',
            'template' => [
                'title' => 'Template kiválasztása',
                '1' => 'Teljes szélességű',
                '2' => 'Tartalmi oldalhoz igazított'
            ],
            'background' => [
                'color' => 'Háttér szín',
                'image' => [
                    'title' => 'Háttér kép',
                    'parallax' => 'Parallax',
                ],
            ],
            'padding' => [
                'title' => 'Belső margó',
                'top' => 'Fent',
                'bottom' => 'Lent',
                'left' => 'Balra',
                'right' => 'Jobbra',
            ],
            'margin' => [
                'title' => 'Külső margó',
                'top' => 'Fent',
                'bottom' => 'Lent',
                'left' => 'Balra',
                'right' => 'Jobbra',
            ],
        ],
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Megnevezés',
            'type' => [
                'title'=>'Típus',
                'all'=>'Mind',
            ],
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Megnevezés',
            'content' => 'Tartalom',
            'type' => [
                'title' => 'Widget típusa',
                'select' => 'Típus kiválasztása',
            ],
            'loyalty' => 'Hűségprogram widget',
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
        ],
        'languages' => [
            'title' => 'Nyelv',
            'choose' => 'Nyelv kiválasztása',
        ],
        'seo' => [
            'title' => 'SEO cím',
            'keywords' => 'SEO kulcsszavak',
            'desc' => 'SEO leírás',
            'max' => 'max. 160 karakter',
            'image' => 'OG kép',
        ],
        'auth' => [
            'title' => 'Hozzáférés típusa',
            'choose' => 'Hozzáférés kiválasztása',
            'public' => 'Publikus',
            'reg' => 'Regisztrált',
        ],
        'template' => [
            'title' => 'Sablon',
            'side' => 'Oldalsó menüvel',
            'full' => 'Teljes szélesség',
        ],
        'public' => [
            'title' => 'Megjelenés ideje',
            'title2' => 'Megjelenés vége',
        ],
        'addthis' => [
            'title' => 'AddThis hozzáadása',
        ],
        'nofollow' => [
            'title' => 'Robotok tiltása',
        ],
        'modules' => [
            'title' => 'Modul generálás',
            'choose' => 'Válasszon modul típust',
            'button' => 'Generálás',
            'add' => 'Widget hozzáadása',
            'element' => [
                'email' => 'E-mail védelem',
                'button' => 'Gomb',
                'content' => 'Tartalom',
                'forms' => 'Űrlapok',
                'grid' => 'Grid',
                'gallery' => [
                    'title' => 'Galéria',
                    'header' => 'Cím',
                    'type' => 'Típus',
                    'simple' => 'Galéria mappa',
                    'list' => 'Galéria lista',
                    'box' => 'Galéria lapozó',
                ],
                'images' => 'Kép',
                'video_category' => 'Videó kategória',
                'video' => 'Videó',
                'document_category' => 'Dokumentum kategória',
                'document' => 'Dokumentum',
            ],
            'grid_options' => [
                'main_title' => 'Beállítások',
                'min_height' => 'Minimum magasság',
                'template' => [
                    'title' => 'Template kiválasztása',
                    '1' => 'Teljes szélességű',
                    '2' => 'Tartalmi oldalhoz igazított'
                ],
                'background' => [
                    'color' => 'Háttér szín',
                    'image' => [
                        'title' => 'Háttér kép',
                        'choose' => 'Kiválasztás',
                        'speed' => 'Mozgás gyorsasága',
                        'parallax' => 'Parallax',
                        'animation' => 'Animáció'
                    ],
                ],
                'text' => [
                    'color' => 'Szöveg szín'
                ],
                'align' => [
                    'title' => 'Dobozok elrendezése',
                    'left' => 'Balra',
                    'center' => 'Középre',
                    'right' => 'Jobbra'
                ],
                'padding' => [
                    'title' => 'Belső margó',
                    'top' => 'Fent',
                    'bottom' => 'Lent',
                    'left' => 'Balra',
                    'right' => 'Jobbra',
                ],
                'margin' => [
                    'title' => 'Külső margó',
                    'top' => 'Fent',
                    'bottom' => 'Lent',
                    'left' => 'Balra',
                    'right' => 'Jobbra',
                ],
            ],
            'boxs' => [
                'email' => [
                    'email' => 'E-mail cím',
                    'text' => 'Megjelenő szöveg',
                ],
                'button' => [
                    'link' => 'Link',
                    'text' => 'Megjelenő szöveg',
                    'ga' => [
                        'event' => 'GA esemény megnevezése',
                    ],
                    'target' => [
                        'title' => 'Link megnyitása',
                        'self' => 'Aktuális oldalban',
                        'new' => 'Új ablakban',
                    ],
                ],
                'forms' => [
                    'title' => 'Űrlapok',
                ],
                'gallery' => [
                    'title' => 'Galériák',
                    'all' => 'Mind'
                ],
                'images' => [
                    'title' => 'Képek',
                ],
                'video_category' => [
                    'title' => 'Video kategóriák',
                    'all' => 'Mind'
                ],
                'video' => [
                    'title' => 'Videók',
                ],
                'document_category' => [
                    'title' => 'Dokumentum kategóriák',
                    'all' => 'Mind'
                ],
                'document' => [
                    'title' => 'Dokumentum',
                ],
            ]
        ],
        'box_list' => [
            'title' => 'Lista dobozok',
            'form' => [
                'column' => 'Oszlopok',
                'box' => 'Dobozok',
                'title' => 'Megnevezés',
            ],
            'element' => [
                'active' => 'Megjelenhet a felhasználók számára?',
                'image' => 'Kép',
                'title' => 'Cím',
                'text' => 'Szöveg',
                'link' => 'Link',
                'color' => 'Doboz alap színe',
                'color2' => 'Doboz mouseover színe',
                'options' => [
                    'header' => 'Elemek',
                    'title' => 'Szöveg',
                    'url' => 'Link',
                    'target' => [
                        'title' => 'Link megnyitása',
                        'window' => 'Aktuális oldalban',
                        'blank' => 'Új ablakban',
                    ],
                ],
                'size' => [
                    'title' => 'Doboz mérete',
                    'small' => 'négyzet (1x1)',
                    'middle' => 'fekvő téglalap (2x1)',
                    'big' => 'álló téglalap (1x2)',
                ]
            ],
            'alerts' => [
                'have' => 'Ezen az oldalon már van ilyen doboz',
            ]
        ],
        'category' => [
            'title' => 'Kategória dobozok',
            'form' => [
                'column' => 'Oszlopok',
                'box' => 'Dobozok',
                'title' => 'Megnevezés',
                'align' => [
                    'title' => 'Elrendezés',
                    'left' => 'Balra zárt',
                    'center' => 'Középre zárt',
                    'right' => 'Jobbra zárt',
                ],
            ],
            'element' => [
                'title' => 'Cím',
                'image' => 'Kép',
                'content' => 'Szöveg',
                'url' => 'Link',
                'target' => [
                    'title' => 'Link megnyitása',
                    'window' => 'Aktuális oldalban',
                    'blank' => 'Új ablakban',
                ],
            ],
        ],
        'parallax' => [
            'title' => 'Redőnyök',
            'form' => [
                'title' => 'Megnevezés',
                'height' => 'Magasság',
                'image' => 'Kép',
                'animation' => 'Animáció',
            ],
        ],
        'counter' => [
            'title' => 'Számláló doboz',
            'form' => [
                'column' => 'Oszlopok',
                'box' => 'Dobozok',
                'title' => 'Megnevezés',
                'align' => [
                    'title' => 'Elrendezés',
                    'left' => 'Balra zárt',
                    'center' => 'Középre zárt',
                    'right' => 'Jobbra zárt',
                ],
            ],
            'element' => [
                'title' => 'Cím',
                'image' => 'Kép',
                'number' => 'Érték',
                'desc' => 'Leírás',
                'unit' => 'Mértékegység'
            ],
        ],
        'tab' => [
            'title' => 'Fülek',
            'form' => [
                'box' => 'Dobozok',
                'title' => 'Megnevezés',
            ],
            'element' => [
                'title' => 'Menü címe',
                'content' => 'Tartalom',
            ],
        ],
        'faq' => [
            'title' => 'GYIK',
            'element' => [
                'title' => 'Kérdés',
                'content' => 'Válasz',
            ],
            'form' => [
                'title' => 'Megnevezés',
                'box' => 'Dobozok',
            ],
        ],
        'map' => [
            'title' => 'Google térkép',
            'form' => [
                'lat' => 'Térkép középponti Lat koordináta',
                'lng' => 'Térkép középponti Lng koordináta',
                'zoom' => 'Zoom tartomány',
                'title' => 'Megnevezés',
                'style' => 'Kinézet kódja',
                'height' => 'Magasság (px-ben)',
                'search' => 'Cím keresés',
                'image' => 'Ikon',
                'width' => [
                    'title' => 'Szélesség',
                    'full' => 'Képernyő szélessége',
                    'content' => 'Tartalom szélessége',
                ],
                'marker' => [
                    'lat' => 'Lat koordináta',
                    'lng' => 'Lng koordináta',
                    'title' => 'Megjelenő cím',
                    'content' => 'Rövid leírás',
                    'url' => 'Link',
                ]
            ],
        ],
    ],
    'dropzone' => [
        'upload' => 'A feltöltéshez húzza ide a fájlokat<br/>(vagy klikkeljen)'
    ],
    'users' => [
        'main' => 'Felhasználók',
        'title' => 'Felhasználók',
        'permission' => 'Regisztráció kezelő',
        'new' => 'Új felhasználó',
        'edit' => 'Felhasználó szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'name' => 'Név',
            'email' => 'E-mail',
            'phone' => 'Telefonszám',
            'last_login' => 'Utolsó bejelentkezés',
            'reg' => 'Felhasználó',
            'login_now' => 'Mai bejelentkezés',
            'newsletter' => 'Hírlevél feliratkozás',
            'newsletters' => [
                'yes' => 'Igen',
                'no' => 'Nem',
            ],
            'created_at' => 'Létrehozva',
            'group' => 'Csoport',
            'groups' => [
                'all' => 'Mind',
                '1' => 'Vendég',
            ],
        ],
        'form' => [
            'name' => 'Név',
            'email' => 'E-mail',
            'password' => 'Jelszó',
            'password_confirmation' => 'Jelszó ismét',
            'phone' => 'Telefonszám',
            'send_email' => 'Jelszó kiküldése?',
            'group' => [
                'title' => 'Csoport',
                'placeholder' => 'Csoport kiválasztása',
                '1' => 'Vendég',
            ],
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már van ilyen felhasználó',
        ],
    ],
    'popup' => [
        'title' => 'Popup',
        'permission' => 'Popup kezelő',
        'new' => 'Új popup',
        'edit' => 'Popup szerkesztése',
        'text' => 'Szöveg elhelyezkedése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Megnevezés',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Megnevezés',
            'button' => 'Gomb címe (ha kell gomb)',
            'link' => 'Link',
            'target' => [
                'title' => 'Link megnyitása',
                'self' => 'Saját ablakban',
                'new' => 'Új ablakban',
            ],
            'type' => [
                'title' => 'Egyszer jelenjen meg látogatásonként?',
                'yes' => 'Igen',
                'no' => 'Nem',
            ],
            'main_type' => [
                'title' => 'Popup típusa',
                '0' => 'Szöveges',
                '1' => 'Képes (háttérkép)',
            ],
            'second' => 'Hány másodpercenként jelenjen meg?',
            'pages' => [
                'title' => 'Melyik oldalon jelenjen meg?',
                'placeholder' => 'Oldalak kiválasztása',
                'type' => [
                    'fixed' => 'Fix oldalak',
                    'all' => 'Minden oldalon',
                    'home' => 'Főoldal',
                    'products' => 'Termékek',
                    'products_all' => 'Összes termék',
                    'pages' => 'Oldalak',
                    'pages_all' => 'Összes oldal',
                    'feeds' => 'Cikkek',
                    'feeds_all' => 'Összes cikk',
                    'labels' => 'Cikk címkék',
                    'labels_all' => 'Összes cikk címkék',
                    'feed_categories' => 'Cikk kategóriák',
                    'feed_categories_all' => 'Összes cikk kategóriák',
                ]
            ],
            'content' => 'Szöveg',
            'title2' => 'Megejelenő cím',
            'image' => 'Kép',
            'text' => [
                'color' => 'Szöveg színe',
                'bgColor' => 'Doboz háttérszíne',
                'position' => [
                    'title' => 'Szöveg elrendezése',
                    'left' => 'Balra zárt',
                    'center' => 'Középre zárt',
                    'right' => 'Jobbra zárt',
                ],
                'image' => 'A képre kattintva tudjuk a doboz elhelyezkedését beállítani',
            ]
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
        ],
    ],
    'forms' => [
        'title' => 'Űrlapok',
        'permission' => 'Űrlapkezelő',
        'new' => 'Új űrlap',
        'edit' => 'Űrlap szerkesztése',
        'live' => 'Kiélesítve',
        'notlive' => 'Kiélesítés',
        'copy' => 'Másolás',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Megnevezés',
            'live' => 'Státusz',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Megnevezés',
            'sendy' => 'Sendy listának az azonosítója',
            'menu' => [
                'text' => 'Egysoros szöveg',
                'textarea' => 'Többsoros szöveg',
                'email' => 'E-mail cím',
                'date' => 'Dátum',
                'number' => 'Szám',
                'checkbox' => 'Jelölődoboz',
                'radio' => 'Rádiógomb',
                'select' => 'Legördülő lista',
                'range' => 'Csúszka',
                'button' => 'Gomb',
                'html' => 'Megjegyzés',
                'aszf' => 'ÁSZF',
                'file' => 'Csatolmány',
                'map' => 'Térkép',
                'newsletter' => 'Hírlevél feliratkozás',
                'grid' => 'Grid',
            ],
            'elements' => [
                'title' => 'Megnevezés',
                'required' => 'Kötelező mező?',
                'hidden' => 'Rejtve legyen?',
                'label' => 'Megjelenő cím',
                'placeholder' => 'Űrlapmező kitöltő szövege',
                'help' => 'Segítség a kitöltéshez',
                'regex' => 'Regex',
                'min' => 'Minimum karakter',
                'max' => 'Maximum karakter',
                'step' => 'Lépések mértéke',
                'min_number' => 'Minimum érték',
                'max_number' => 'Maximum érték',
                'unique' => 'Csak egyszer töltheti ki?',
                'aszf' => 'Adatvédelem szövege',
                'max_file' => 'Maximum feltölthető fájlok száma',
                'max_size' => 'Fájlonként feltölthető maximum méret MB-ban',
                'extension' => 'Kiterjesztések ","-vel elválasztva',
                'lat' => 'Térkép középponti Lat koordináta',
                'lng' => 'Térkép középponti Lng koordináta',
                'zoom' => 'Zoom tartomány',
                'height' => 'Magasság (px-ben)',
                'style' => 'Kinézet kódja',
                'newsletter' => 'Hírlevél feliratkozás szövege',
                'option' => [
                    'header' => 'Választható elemek',
                    'title' => 'Megjelenő cím',
                    'value' => 'Érték'
                ],
                'html' => 'Egyéb megjegyzés',
                'button' => [
                    'text' => 'Gomb szövege',
                    'align' => 'Gomb elhelyezkedése',
                    'left' => 'Baloldalon',
                    'center' => 'Középen',
                    'right' => 'Jobboldalon',
                ],
                'date' => 'Dátum formátuma <small>pl: YYYY.MM.DD HH:II:SS</small>',
            ]
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'live' => 'Már ki lett élesítve, így nem lehet az űrlap elemeit szerkeszteni',
            'not' => 'Nem lehet kiélesíteni',
            'liveSuccess' => 'Sikeresen kiélesítve',
            'copyError' => 'Nem sikerült lemásolni',
            'copySuccess' => 'Sikeresen lemásolva a kiválasztott nyelvhez',
        ],
    ],
    'form_users' => [
        'title' => 'Kitöltők',
        'permission' => 'Űrlap kitöltők',
        'show' => 'Megtekintés',
        'table' => [
            'id' => 'Azonosító',
            'created_at' => 'Létrehozva',
            'reg' => 'Kitöltő',
            'reg_now' => 'Mai kitöltő',
            'page' => 'Erről az oldalról regisztrált',
        ],
        'form' => [

        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
        ],
    ],
    'form_content' => [
        'title' => 'Űrlap tartalmak',
        'permission' => 'Űrlap tartalmak',
        'new' => 'Új tartalom',
        'edit' => 'Tartalom szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'type' => 'Típus',
            'created_at' => 'Létrehozva',
        ],
        'form' => [
            'type' => [
                'title' => 'Típus',
                '1' => 'E-mailt küld nekünk',
                '2' => 'E-mailt küld a kitöltőnek (Ha van e-mail típusú mező)',
                '3' => 'Sikeres oldal',
            ],
            'emails' => 'E-mail címek <small>(","-el elválasztva több e-mail cím is megadható)</small>',
            'subject' => 'Tárgy',
            'content' => 'Tartalom',
            'codes' => 'Elhelyezhető kódok',
            'code' => 'Kódok',
            'desc' => 'Leírás',
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már van ilyen tartalom ennél az űrlapnál',
        ],
    ],
    'logs' => [
        'title' => 'Logok',
        'permission' => 'Logok',
        'more' => 'További tartalmak',
        'table' => [
            'id' => 'Azonosító',
            'name' => 'Felhasználó',
            'all' => 'Mind',
            'type_id' => 'Típus azonosító',
            'type' => 'Típus',
            'action' => 'Művelet',
            'actions' => [
                '1' => 'Új',
                '2' => 'Szerkesztés',
                '3' => 'Törlés',
                '4' => 'Státusz',
                '5' => 'Rendezés',
                '6' => 'Export',
                '7' => 'Végleges törlés',
                '8' => 'Visszaállítás',
                '9' => 'Frissítés',
                '10' => 'Kiemelés',
                '11' => 'Kiélesítve',
                '12' => 'Másolás',
            ],
            'created_at' => 'Létrehozva',
        ],
        'form' => [

        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
        ],
    ],
    'events_xml' => [
        'title' => 'Események xml',
        'permission' => 'Események xml kezelő',
        'new' => 'Új xml',
        'edit' => 'Xml szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'link' => 'Link',
            'type' => [
                'title' => 'Típus',
                'all' => 'Mind',
                '1' => 'Export',
                '2' => 'Import',
            ],
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'link' => 'Link',
            'categories' => [
                'title' => 'Exportálandó kategóriák',
                'placeholder' => 'Kérjük, válasszon kategóriát',
            ],
            'type' => [
                'title' => 'Típus',
                'choose' => 'Típus kiválasztása',
                '1' => 'Export',
                '2' => 'Import',
            ],
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már létezik ez a kategória',
        ],
    ],
    'event_categories' => [
        'title' => 'Esemény kategóriák',
        'permission' => 'Esemény kategóriakezelő',
        'new' => 'Új kategória',
        'edit' => 'Kategória szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'slug' => 'Keresőbarát cím',
            'color' => 'Háttér színe',
            'color2' => 'Szöveg színe',
            'image' => 'Ikon',
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már létezik ez a kategória',
        ],
    ],
    'events' => [
        'main' => 'Események',
        'title' => 'Események',
        'permission' => 'Eseménykezelő',
        'new' => 'Új esemény',
        'edit' => 'Esemény szerkesztése',
        'table' => [
            'id' => 'Azonosító',
            'title' => 'Cím',
            'category' => [
                'title' => 'Kategória',
                'all' => 'Mind',
            ],
            'active_at' => 'Aktiválás',
            'deleted_at' => 'Törölve',
        ],
        'form' => [
            'title' => 'Cím',
            'slug' => 'Keresőbarát cím',
            'short' => 'Leírás',
            'content' => 'Tartalom',
            'place' => 'Helyszín',
            'event_start' => 'Esemény kezdete',
            'event_end' => 'Esemény vége',
            'image' => 'Kép',
            'category' => [
                'title' => 'Kategóriák',
                'placeholder' => 'Kategóriák kiválasztása'
            ],
        ],
        'alerts' => [
            'notfound' => 'Nincs találat',
            'have' => 'Már létezik ez az esemény',
        ],
    ],
];