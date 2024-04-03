
#include "connection.h"

Connection::Connection()
{

}

bool Connection::createconnection()
{
    QSqlDatabase db = QSqlDatabase::addDatabase("QODBC");
    db.setDatabaseName("Projet2A");
    db.setUserName("Nour");
    db.setPassword("esprit24");

    if (!db.open()) {
        QMessageBox::critical(nullptr, "Database Error", db.lastError().text());
        return false;
    } else {
        return true;
    }
}
