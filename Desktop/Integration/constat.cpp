#include "constat.h"
#include "aminee.h"
#include <QSqlError>
#include <QDebug>
#include <QSqlQuery>
#include <QSqlError>
#include <QtDebug>
#include <QSqlError>
#include <QDebug>
#include <QSqlQuery>
#include <QSqlError>
#include <QtDebug>
#include <QMessageBox>
#include <QFile>
#include <QIODevice>
#include <QtSql/QSqlRecord>
#include <QMessageBox>
#include <QFile>
#include <QIODevice>

constat::constat(QString ID, QString dateConstat, QString lieuConstat, QString typeConstat, QString description, QString signature)
{
    this->ID = ID;
    this->dateConstat = dateConstat;
    this->lieuConstat = lieuConstat;
    this->typeConstat = typeConstat;
    this->description = description;
    this->signature = signature;
}

bool constat::ajouter()
{
    QSqlQuery query;
    query.prepare("INSERT INTO CONSTATS(ID, DATE_CONSTAT, LIEU_CONSTAT, TYPE_CONSTAT, DESCRIPTION, SIGNATURE) "
                  "VALUES (:ID, :dateConstat, :lieuConstat, :typeConstat, :description, :signature)");

    // Liage des valeurs aux paramètres
    query.bindValue(":ID", ID);
    query.bindValue(":dateConstat", dateConstat);
    query.bindValue(":lieuConstat", lieuConstat);
    query.bindValue(":typeConstat", typeConstat);
    query.bindValue(":description", description);
    query.bindValue(":signature", signature);

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

bool constat::modifierConstat(const QString& ID, const QString& nouvelleDateConstat, const QString& nouveauLieuConstat, const QString& nouvelleSignature)
{
    QSqlQuery query;
    query.prepare("UPDATE CONSTATS SET DATE_CONSTAT = :nouvelleDateConstat, LIEU_CONSTAT = :nouveauLieuConstat, SIGNATURE = :nouvelleSignature WHERE ID = :ID");
    query.bindValue(":nouvelleDateConstat", nouvelleDateConstat);
    query.bindValue(":nouveauLieuConstat", nouveauLieuConstat);
    query.bindValue(":nouvelleSignature", nouvelleSignature);
    query.bindValue(":ID", ID);

    if (!query.exec())
    {
        qDebug() << "Échec de l'exécution de la requête:" << query.lastError().text();
        qDebug() << "Erreur Oracle:" << query.lastError().databaseText();
        return false;
    }
    else
    {
        qDebug() << "Modification de la date, du lieu et de la signature du constat réussie.";
        return true;
    }
}


bool constat::supprimer(const QString& ID)
{
    QSqlQuery query;
    query.prepare("DELETE FROM CONSTATS WHERE ID = :ID");
    query.bindValue(":ID", ID);

    if (!query.exec())
    {
        qDebug() << "Échec de l'exécution de la requête:" << query.lastError().text();
        qDebug() << "Erreur Oracle:" << query.lastError().databaseText();
        return false;
    }
    else
    {
        qDebug() << "Suppression du constat réussie.";
        return true;
    }
}

QSqlQueryModel* constat::afficher()
{
    QSqlQueryModel* model = new QSqlQueryModel();
    model->setQuery("SELECT ID, DATE_CONSTAT, LIEU_CONSTAT, TYPE_CONSTAT, DESCRIPTION, SIGNATURE FROM CONSTATS");

    // Définir les en-têtes
    model->setHeaderData(0, Qt::Horizontal, QObject::tr("ID"));
    model->setHeaderData(1, Qt::Horizontal, QObject::tr("Date du Constat"));
    model->setHeaderData(2, Qt::Horizontal, QObject::tr("Lieu du Constat"));
    model->setHeaderData(3, Qt::Horizontal, QObject::tr("Type du Constat"));
    model->setHeaderData(4, Qt::Horizontal, QObject::tr("Description"));
    model->setHeaderData(5, Qt::Horizontal, QObject::tr("Signature"));

    return model;


}

QSqlQueryModel* constat::TriPar(QString typeConstat)
{
    QSqlQueryModel* model = new QSqlQueryModel();
    QSqlQuery query;

    // Vérification du critère de tri
    QString orderByClause;
    if (typeConstat == "TYPE_CONSTAT") {
        orderByClause = "ORDER BY TYPE_CONSTAT";
    } else {
        qDebug() << "Critère de tri invalide :" << typeConstat;
        delete model;
        return nullptr;
    }

    // Exécution de la requête
    QString queryString = "SELECT ID, DATE_CONSTAT, LIEU_CONSTAT, TYPE_CONSTAT, DESCRIPTION, SIGNATURE FROM CONSTATS " + orderByClause;
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


QStandardItemModel* constat::recherche(QString str, bool rechercheParID) {
    QSqlQuery query;
    QStandardItemModel *model = new QStandardItemModel();

    // Définir les en-têtes du modèle
    model->setHorizontalHeaderLabels({ "ID", "DATE_CONSTAT", "LIEU_CONSTAT", "TYPE_CONSTAT", "DESCRIPTION", "SIGNATURE" });

    QString queryString;
    if (rechercheParID) {
        queryString = "SELECT ID, DATE_CONSTAT, LIEU_CONSTAT, TYPE_CONSTAT, DESCRIPTION, SIGNATURE FROM CONSTATS WHERE ID = :recherche";
    } else {
        // Gérer les autres critères de recherche si nécessaire
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



