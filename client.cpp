#include "client.h"
#include <QSqlQuery>
#include <QSqlError>
#include <QDebug>
#include <QMessageBox>
#include <QFile>
#include <QIODevice>
#include <QSqlError>
#include <QDebug>
#include <QSqlQuery>
#include <QSqlError>
#include <QtDebug>
#include <QMessageBox>
#include <QFile>
#include <QIODevice>
#include <QtSql/QSqlRecord>


Client::Client(QString cin, QString nom, QString prenom, QString adresse, QString numeroTelephone, QString email)
{
    this->cin = cin;
    this->nom = nom;
    this->prenom = prenom;
    this->adresse = adresse;
    this->numeroTelephone = numeroTelephone;
    this->email = email;
}

bool Client::ajouter()
{
    // Vérifier la longueur du CIN
    if (cin.length() > 20)
    {
        QMessageBox::critical(nullptr, "Erreur", "Le CIN ne peut pas dépasser 20 caractères.");
        return false;
    }

    // Vérifier la longueur du numéro de téléphone
    if (numeroTelephone.length() < 8 || numeroTelephone.length() > 15) // Limite de 8 à 15 chiffres pour le numéro de téléphone
    {
        QMessageBox::critical(nullptr, "Erreur", "Le numéro de téléphone doit contenir entre 8 et 15 chiffres.");
        return false;
    }

    QSqlQuery query;
    query.prepare("INSERT INTO CLIENTS(CIN, NOM, PRENOM, ADRESSE, NUMTEL, EMAIL) "
                  "VALUES (:cin, :nom, :prenom, :adresse, :numeroTelephone, :email)");

    // Liage des valeurs aux paramètres
    query.bindValue(":cin", cin);
    query.bindValue(":nom", nom);
    query.bindValue(":prenom", prenom);
    query.bindValue(":adresse", adresse);
    query.bindValue(":numeroTelephone", numeroTelephone);
    query.bindValue(":email", email);

    if (!query.exec())
    {
        qDebug() << "Échec de l'exécution de la requête:" << query.lastError().text();
        qDebug() << "Erreur Oracle:" << query.lastError().databaseText();
        return false;
    }
    else
    {
        qDebug() << "Insertion réussie.";
        return true;
    }
}
bool Client::supprimer(const QString& cin)
{
    QSqlQuery query;
    query.prepare("DELETE FROM CLIENTS WHERE CIN = :cin");
    query.bindValue(":cin", cin);

    if (!query.exec())
    {
        qDebug() << "Échec de l'exécution de la requête:" << query.lastError().text();
        qDebug() << "Erreur Oracle:" << query.lastError().databaseText();
        return false;
    }
    else
    {
        qDebug() << "Suppression réussie.";
        return true;
    }
}

QSqlQueryModel* Client::afficher()
{
    QSqlQueryModel* model = new QSqlQueryModel();
    model->setQuery("SELECT CIN, NOM, PRENOM, ADRESSE, NUMTEL, EMAIL FROM CLIENTS");

    // Définir les en-têtes
    model->setHeaderData(0, Qt::Horizontal, QObject::tr("CIN"));
    model->setHeaderData(1, Qt::Horizontal, QObject::tr("Nom"));
    model->setHeaderData(2, Qt::Horizontal, QObject::tr("Prénom"));
    model->setHeaderData(3, Qt::Horizontal, QObject::tr("Adresse"));
    model->setHeaderData(4, Qt::Horizontal, QObject::tr("Numéro de Téléphone"));
    model->setHeaderData(5, Qt::Horizontal, QObject::tr("Email"));

    return model;
}

bool Client::modifier(const QString& cin, const QString& nouveauNumeroTelephone, const QString& nouvelleAdresse, const QString& nouvelEmail)
{
    QSqlQuery query;
    query.prepare("UPDATE CLIENTS SET NUMTEL = :nouveauNumeroTelephone, ADRESSE = :nouvelleAdresse, EMAIL = :nouvelEmail WHERE CIN = :cin");
    query.bindValue(":nouveauNumeroTelephone", nouveauNumeroTelephone);
    query.bindValue(":nouvelleAdresse", nouvelleAdresse);
    query.bindValue(":nouvelEmail", nouvelEmail);
    query.bindValue(":cin", cin);

    if (!query.exec())
    {
        qDebug() << "Échec de l'exécution de la requête:" << query.lastError().text();
        qDebug() << "Erreur Oracle:" << query.lastError().databaseText();
        return false;
    }
    else
    {
        qDebug() << "Modification réussie.";
        return true;
    }
}

QStandardItemModel* Client::rechercheClient(QString str, bool rechercheParCIN) {
    QSqlQuery query;
    QStandardItemModel *model = new QStandardItemModel();

    // Définir les en-têtes du modèle
    model->setHorizontalHeaderLabels({ "CIN", "NOM", "PRENOM", "ADRESSE", " NUMTEL,", "EMAIL" });

    QString queryString;
    if (rechercheParCIN) {
        queryString = "SELECT CIN, NOM, PRENOM, ADRESSE, NUMTEL, EMAIL FROM CLIENTS WHERE CIN = :recherche";
    } else {
        qDebug() << "Critère de recherche invalide.";
        return nullptr;
    }

    query.prepare(queryString);
    query.bindValue(":recherche", str);

    if (query.exec()) {
        while (query.next()) {
            QList<QStandardItem*> row;
            for (int i = 0; i < query.record().count(); ++i) {
                row.append(new QStandardItem(query.value(i).toString()));
            }
            model->appendRow(row);
        }
    } else {
        qDebug() << "Échec de la requête :" << query.lastError();
    }

    return model;
}
QSqlQueryModel* Client::TriPar(QString nom)
{
    QSqlQueryModel* model = new QSqlQueryModel();
    QSqlQuery query;

    // Vérification du critère de tri
    QString orderByClause;
    if (nom == "NOM") {
        orderByClause = "ORDER BY NOM";
    } else {
        qDebug() << "Critère de tri invalide :" << nom;
        delete model;
        return nullptr;
    }

    // Exécution de la requête
    QString queryString = "SELECT CIN, NOM, PRENOM, ADRESSE, NUMTEL, EMAIL FROM CLIENTS " + orderByClause;
    if (!query.exec(queryString)) {
        qDebug() << "Échec de l'exécution de la requête:" << query.lastError().text();
        qDebug() << "Erreur Oracle:" << query.lastError().databaseText();
        delete model;
        return nullptr;
    }

    // Définition du modèle avec la requête triée
    model->setQuery(query);

    return model;
}

