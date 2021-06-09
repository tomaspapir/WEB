# WEB
Semestrální práce z KIV/WEB - Konferenční systém

**1. Použité technologie** <br />
        **a. Bootstrap** <br />
        Celý front-end webu je postaven pomocí bootstrapu, za zmínku stojí třeba různá 
        upozornění pro uživatele, všechny tlačítka, menu, footer, úprava vzhledu nebo
        celá responzivita webu. <br />
        **b. FontAwesome** <br />
        Pomocí FontAwesome jsou zařízeny veškeré ikony webu <br />
        **c. PHP** <br />
        V programovacím jazyku PHP je vytvořená celá backendová část webu. 
        Například načítání veškerých článků, uživatelských dat, ošetření vstupů nebo 
        komunikace s databází. <br />
        **d. phpMyAdmin/SQL** <br />
        Databáze článků, jejich hodnocení, uživatelů a jejich rolí <br />
        **e. Javascript** <br />
        Využito pouze jako vyzkoušení dané technologie <br /> 
        **f. AJAX** <br />
        Využito pouze jako vyzkoušení dané technologie <br />
       <br /> <br />
**2. Popis architektury aplikace**<br />
Aplikace splňuje MVC<br />
**About** – Vypíše stránku „O stránce“ kde si je možné vyzkoušet AJAX (controller + view)<br />
**ArticleManagement** – Vypíše stránku „Správa článků“, kde administrátor spravuje 
přidané články (controller + view)<br />
**ControllerBasics** – Třída sloužící k načtení všech dat do pole TplData<br />
**Download** – Provede stažení PDF dokumentu daného článku (controller)<br />
**Homepage** – Vypíše stránku „Domovská stránka, kde nepřihlášený uživatel může vidět 
schválené články a kde přihlášený uživatel může přidávat články nové (controller + view)<br />
**IController.interface** – rozhraní ovladačů<br />
**InsertReview** – Pokud je uživatel recenzent, tak vypíše stránku, kde může ohodnotit 
jemu přiřazený článek (controller + view)<br />
**Login** – Vypíše stránku „Přihlášení uživatele“, kde se uživatel může přihlásit
(controller + view)<br />
**NewArticle** – Vypíše stránku „Nový článek“, kde přihlášený uživatel může odeslat 
nový článek ke schválení (controller + view)<br />
**Registration** – Vypíše stránku „Registrace uživatele“, kde se uživatel může 
zaregistrovat (controller + view)<br />
**UserManagement** – Pokud je přihlášený uživatel administrátor, tak zde může 
spravovat uživatele, jinak je zde vypsán aktuálně přihlášený uživatel (controller + view)<br />
**ViewArticle** – Zobrazí článek podle GET (controller + view)<br />
**ViewReview** – Zobrazení daného hodnocení, které recenzent vytvořil
(controller + view)<br />
**DatabaseModel** – Obsahuje funkce sloužící k práci s databází<br />
**TemplateBasics** – Obsahuje includes a html pro footer a menu (template)<br />
