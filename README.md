
# Progetto di Tecnologie Web

**Ecommerce di <del>Final Fantasy</del> un videogioco fantasy**: perchè?</br>
-> gestione acquisti ingame di Zonko</br>
-> è più carino dei soliti ecommerce fake, tutti uguali...</br>
-> ...

---
### Dopo il git clone
    Andare col terminale nella directory del repository e lanciare questi comandi 
* `composer install` 
dovrebbe aggiungere tutti i file mancanti, tranne quelli di configurazione

* `cp .env.example .env` genera un file di configurazione nel quale bisogna inserire le credenziali per accedere al DB locale

* `php artisan migrate` per aggiornare la struttura del database (in teoria andrebbe ripetuto dopo ogni pull)

*  `php artisan key:generate` per generare l'application key

* (solo per Valet) `valet link zonkoshop` renderà disponibile il sito all'indirizzo http://zonkoshop.test

---

### Cose da chiedere al Prof:
	Il prof ha dato appuntamento 
	Venerdì 12/04/2019 alle 9:30-10:00, in Lab. Info 1

- <mark>Query Scope</mark> (in particolare global scope e metodo boot)

- <mark>AJAX con JQuery in Laravel</mark>
	
	- Come ottenere l'URL di una route dato il suo nome in un file JS? **Fregatene e mettilo pure hardcoded, oppure passalo come parametro a una funzione invocata nel file .blade.php con le {{ }}**
	- Meglio incorporare il codice delle chiamate AJAX nei file *.blade.php o caricare da un *.js esterno? **Indifferente, ma dentro al file .blade.php si possono inserire cose con le {{  }} di Blade**
	- Quanto AJAX dobbiamo inserire? **Non c'è un limite**
	
- Service Container e Service Provider: ci possono servire? **NO**


  
---
## Entità-Relazioni

https://dbdiagram.io/d/5cd31219f7c5bb70c72fec80

### Modelli/Entità di base:
- Utenti (Usiamo la gestione utenti di Laravel)
- Categorie
- Prodotti
- Carrelli
- Ordini
- Recensioni prodotto (solo se necessario per soddisfare il requisito "Almeno un'entità con CRUD completo")



---
## Requisiti

### Generali
- La parte in alto della home deve avere una barra di ricerca dei prodotti, con autocompletamento (HTML datalist)
- La home presenta alcuni articoli a mo' Amazon
- Ci sono diversi tipi di utente: admin, clienti (e fornitori?)

### Ruoli utente
- Gli utenti possono essere <u>clienti</u> o <u>admin</u>
- ~~I clienti possono essere guerrieri, maghi o personaggi di supporto.~~
- ~~Ciascuna classe ha accesso esclusivo ad alcuni articoli (es: il mago può comprare magie ma non armi pesanti)~~
- L'admin ha più potere, può aggiungere categorie e modificare i dati degli articoli, ad esempio, mediante dei pulsanti sulle rispettive pagine.
- Questi pulsanti non sono visibili agli utenti non-admin
- Gli admin hanno una pagina riservata per cercare categorie, prodotti e tutto quello che possono gestire
- Gli admin possono navigare per il negozio come gli utenti ma non possono fare acquisti perchè non hanno un carrello

### Prodotti cancellati
- Quando un admin cancella un prodotto, esso non deve essere fisicamente eliminato dal database.
- I prodotti eliminati da un admin non devono più essere visibili nel negozio. Devono però continuare ad apparire nell'elenco degli ordini o nel carrello, con un avvertimento sulla loro non-disponibilità.
- Se il carrello contiene prodotti non più disponibili, l'utente non deve poter completare l'acquisto

### Login
- Il login viene richiesto per vedere il carrello o per aggiungervi articoli
- Si può fare il logout
- Dopo il login, in base alla tipologia di utente:
- cliente -> redirect alla pagina precedente
	- admin -> redirect alla pagina con le categorie



</br>
</br>

### Se proprio avanza tempo...
- Permettere agli utenti di modificare ed eliminare il proprio profilo
- I clienti possono essere guerrieri, maghi, personaggi di supporto...
- Ciascuna classe utente ha accesso esclusivo ad alcuni articoli.
  Ad es: il mago può comprare magie ma non armi pesanti
# zonkoshop
