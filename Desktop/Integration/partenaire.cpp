#include "partenaire.h"
#include <QSqlError>
#include <QDebug>
#include <QSqlQuery>
#include <QSqlError>
#include <QtDebug>
#include <QMessageBox>
#include <QFile>
#include <QIODevice>
#include <QtSql/QSqlRecord>

Partenaire::Partenaire(QString matriculeFiscale, QString nomEntreprise, QString adresse, QString numeroTelephone, QDate debutContrat, QDate finContrat, QString secteurActivite, QString interet, QString cheminImage)
{
    this->matriculeFiscale = matriculeFiscale;
    this->nomEntreprise = nomEntreprise;
    this->adresse = adresse;
    this->numeroTelephone = numeroTelephone;
    this->debutContrat = debutContrat; // Initialiser le nouvel attribut debutContrat
    this->finContrat = finContrat;     // Initialiser le nouvel attribut finContrat
    this->secteurActivite = secteurActivite;
    this->interet = interet;
    this->cheminImage = cheminImage;
}
bool Partenaire::ajouter()
{
    // Vérifier la longueur de la matricule fiscale
    if (matriculeFiscale.length() > 10)
    {
        QMessageBox::critical(nullptr, "Erreur", "La matricule fiscale ne peut pas dépasser 10 caractères.");
        return false;
    }

    // Vérifier la longueur du numéro de téléphone
    if (numeroTelephone.length() < 8 || numeroTelephone.length() > 15) // Limite de 8 à 15 chiffres pour le numéro de téléphone
    {
        QMessageBox::critical(nullptr, "Erreur", "Le numéro de téléphone doit contenir entre 8 et 15 chiffres.");
        return false;
    }

    QSqlQuery query;
    query.prepare("INSERT INTO FOOL(MATRICULE_FISCALE, NOM_ENTREPRISE, ADRESSE, NUMERO_TELEPHONE, DEBUT_CONTRAT, FIN_CONTRAT, SECTEUR_ACTIVITE, INTERET, IMAGE) "
                  "VALUES (:matriculeFiscale, :nomEntreprise, :adresse, :numeroTelephone, :debutContrat, :finContrat, :secteurActivite, :interet, :image)");

    // Liage des valeurs aux paramètres
    query.bindValue(":matriculeFiscale", matriculeFiscale);
    query.bindValue(":nomEntreprise", nomEntreprise);
    query.bindValue(":adresse", adresse);
    query.bindValue(":numeroTelephone", numeroTelephone);
    query.bindValue(":debutContrat", debutContrat); // Nouvel attribut debutContrat
    query.bindValue(":finContrat", finContrat);     // Nouvel attribut finContrat
    query.bindValue(":secteurActivite", secteurActivite);
    query.bindValue(":interet", interet);

    // Convertir l'image en QByteArray
    QFile imageFile(cheminImage);
    if (imageFile.open(QIODevice::ReadOnly)) {
        QByteArray imageByteArray = imageFile.readAll();
        query.bindValue(":image", imageByteArray);
        imageFile.close();
    } else {
        qDebug() << "Échec de l'ouverture de l'image.";
        return false;
    }

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

bool Partenaire::supprimer(const QString& matriculeFiscale)
{
    QSqlQuery query;
    query.prepare("DELETE FROM FOOL WHERE MATRICULE_FISCALE = :matriculeFiscale");
    query.bindValue(":matriculeFiscale", matriculeFiscale);

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
QSqlQueryModel* Partenaire::afficher()
{
    QSqlQueryModel* model = new QSqlQueryModel();
    model->setQuery("SELECT MATRICULE_FISCALE, NOM_ENTREPRISE, ADRESSE, NUMERO_TELEPHONE, DEBUT_CONTRAT, FIN_CONTRAT, SECTEUR_ACTIVITE, INTERET  FROM FOOL");

    // Définir les en-têtes
    model->setHeaderData(0, Qt::Horizontal, QObject::tr("Matricule Fiscale"));
    model->setHeaderData(1, Qt::Horizontal, QObject::tr("Nom de l'Entreprise"));
    model->setHeaderData(2, Qt::Horizontal, QObject::tr("Adresse"));
    model->setHeaderData(3, Qt::Horizontal, QObject::tr("Numéro de Téléphone"));
    model->setHeaderData(4, Qt::Horizontal, QObject::tr("Début Contrat"));
    model->setHeaderData(5, Qt::Horizontal, QObject::tr("Fin Contrat"));
    model->setHeaderData(6, Qt::Horizontal, QObject::tr("Secteur d'Activité"));
    model->setHeaderData(7, Qt::Horizontal, QObject::tr("Intérêt"));


    return model;
}
bool Partenaire::modifierContrat(const QString& matriculeFiscale, const QString& nouveauNomEntreprise, const QString& nouvelleAdresse,const QString& nouveauNumeroTelephone)
{
    QSqlQuery query;
    query.prepare("UPDATE FOOL SET NOM_ENTREPRISE = :nouveauNomEntreprise, ADRESSE = :nouvelleAdresse,NUMERO_TELEPHONE = :nouveauNumeroTelephone WHERE MATRICULE_FISCALE = :matriculeFiscale");
    query.bindValue(":nouveauNomEntreprise", nouveauNomEntreprise);
    query.bindValue(":nouvelleAdresse", nouvelleAdresse);
    query.bindValue(":nouveauNumeroTelephone", nouveauNumeroTelephone);


    query.bindValue(":matriculeFiscale", matriculeFiscale);


    if (!query.exec())
    {
        qDebug() << "Échec de l'exécution de la requête:" << query.lastError().text();
        qDebug() << "Erreur Oracle:" << query.lastError().databaseText();
        return false;
    }
    else
    {
        qDebug() << "Modification du nom et de l'adresse du partenaire réussie.";
        return true;
    }
}
QSqlQueryModel* Partenaire::TriPar(QString nomEntreprise)
{
    QSqlQueryModel* model = new QSqlQueryModel();
    QSqlQuery query;

    // Vérification du critère de tri
    QString orderByClause;
    if (nomEntreprise == "NOM_ENTREPRISE") {
        orderByClause = "ORDER BY NOM_ENTREPRISE";
    } else {
        qDebug() << "Critère de tri invalide :" <<nomEntreprise;
        delete model;
        return nullptr;
    }

    // Exécution de la requête
    QString queryString = "SELECT MATRICULE_FISCALE, NOM_ENTREPRISE, ADRESSE, NUMERO_TELEPHONE,DEBUT_CONTRAT, FIN_CONTRAT, SECTEUR_ACTIVITE, INTERET FROM FOOL " + orderByClause;
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

QStandardItemModel* Partenaire::recherche(QString str, bool rechercheParMatricule) {
    QSqlQuery query;
    QStandardItemModel *model = new QStandardItemModel();

    // Définir les en-têtes du modèle
    model->setHorizontalHeaderLabels({ "MATRICULE_FISCALE", "NOM_ENTREPRISE", "ADRESSE", "NUMERO_TELEPHONE", "DEBUT_CONTRAT", "FIN_CONTRAT", "SECTEUR_ACTIVITE", "INTERET" });

    QString queryString;
    if (rechercheParMatricule) {
        queryString = "SELECT MATRICULE_FISCALE, NOM_ENTREPRISE, ADRESSE, NUMERO_TELEPHONE, DEBUT_CONTRAT, FIN_CONTRAT, SECTEUR_ACTIVITE, INTERET FROM FOOL WHERE MATRICULE_FISCALE = :recherche";
    } else {
        queryString = "SELECT MATRICULE_FISCALE, NOM_ENTREPRISE, ADRESSE, NUMERO_TELEPHONE, DEBUT_CONTRAT, FIN_CONTRAT, SECTEUR_ACTIVITE, INTERET FROM FOOL WHERE NOM_ENTREPRISE LIKE :recherche";
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
        qDebug() << "Query failed:" << query.lastError();
    }

    return model;
}





