#include "pointagee.h"
#include "ui_pointagee.h"
#include <QSqlQueryModel>
#include <QSqlQuery>
#include <QSqlError>
#include <QDebug>
#include "employe.h"

pointagee::pointagee(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::pointagee)
{
    ui->setupUi(this);


    ui->setupUi(this);

    // Créer un modèle pour contenir les données de la table
    QSqlQueryModel *model = new QSqlQueryModel(this);
    QSqlQuery query;

    // Exécuter une requête SQL pour sélectionner les données de la table EMPLOYEEE
    query.prepare("SELECT NOM, PRENOM, IDCARD, HE_ENTREE, HE_SORTIE FROM EMPLOYEEE WHERE IDCARD = :idcard");
    query.bindValue(":idcard", "93E8B3F8"); // Remplacer "93E8B3F8" par la valeur recherchée

    if (!query.exec()) {
        qDebug() << "Erreur lors de l'exécution de la requête:" << query.lastError().text();
    }

    // Définir le modèle avec les données de la requête
    model->setQuery(query);

    // Afficher le modèle dans le QTableView
    ui->onsView->setModel(model);
}




pointagee::~pointagee()
{
    delete ui;
}


