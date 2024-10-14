# Sistema di Gestione Fatture di vendita

Sistema di gestione delle fatture basato su PHP che consente agli utenti di creare, modificare, visualizzare e gestire le fatture. 

## Caratteristiche

- Creazione di nuove fatture 
- Modifica delle fatture esistenti con la possibilità di aggiornare le righe di dettaglio o aggiungerne di nuove
- Funzionalità di ricerca per filtrare le fatture in base al cliente
- Design responsive

## Tecnologie Utilizzate

- **PHP**: Logica backend e elaborazione dei dati sul server
- **JavaScript**: Aggiornamenti dinamici dell'interfaccia utente e gestione dei moduli
- **MySQL**: Database per la memorizzazione di fatture e dati dei clienti

## Installazione

Per ottenere una copia locale e farla funzionare, seguire questi passaggi:

1. **Clonare il repository**:
   ```bash
   git clone https://github.com/sofiacottone/sales-invoices.git
   ```

2. **Configurare il database**:

    Creare un nuovo database MySQL.
    Eseguire il file `schema.sql` fornito nel repository per creare le tabelle necessarie.
    Aggiungere la combinazione di `invoice_id` e `description` come chiave univoca nella tabella `invoice_details`:
    ```sql
    ALTER TABLE invoice_details ADD UNIQUE (invoice_id, description);
    ```
3. **Configurare la connessione al database**:
    Aprire il file `config.php` e aggiornare le credenziali del database.
4. **Eseguire l'applicazione**:
   ```bash
   php -S localhost:8888 -t public
   ```
5. **Accedere all'applicazione**:
    Aprire il browser e navigare su http://localhost:8000 per iniziare a gestire le fatture.