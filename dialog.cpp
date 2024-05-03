#include "dialog.h"
#include "ui_dialog.h"
#include <QSqlQueryModel>
#include <QSqlQuery>
#include <QSqlError>
#include <QDebug>
#include "nour.h"
#include "employe.h"

Dialog::Dialog(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::Dialog)
{
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


Dialog::~Dialog()
{
    delete ui;
}

void Dialog::on_pushButton_clicked()
{
    QModelIndexList selectedIndexes = ui->onsView->selectionModel()->selectedIndexes();

    if (selectedIndexes.isEmpty()) {
        qDebug() << "Aucune ligne sélectionnée.";
        return;
    }

    // Exécuter une requête SQL pour mettre à jour les heures d'entrée et de sortie à NULL pour toutes les lignes sélectionnées
    QSqlQuery query;
    query.prepare("UPDATE EMPLOYEEE SET HE_ENTREE = NULL, HE_SORTIE = NULL WHERE rowid = :rowid");

    // Mettre à jour chaque ligne sélectionnée
    for (const QModelIndex& index : selectedIndexes) {
        // Récupérer l'ID de la ligne
        int rowId = index.row() + 1; // Ajoute 1 car les ID de ligne commencent à partir de 1 dans SQLite
        query.bindValue(":rowid", rowId);
        if (!query.exec()) {
            qDebug() << "Erreur lors de la mise à jour des heures d'entrée et de sortie pour la ligne" << rowId << ":" << query.lastError().text();
            return;
        }
    }

    // Rafraîchir le modèle pour refléter les changements dans l'interface utilisateur
    QSqlQueryModel *model = qobject_cast<QSqlQueryModel*>(ui->onsView->model());
    if (model) {
        QSqlQuery refreshQuery = model->query(); // Enregistrer la requête SQL du modèle
        if (!refreshQuery.exec()) {
            qDebug() << "Erreur lors du rafraîchissement du modèle:" << refreshQuery.lastError().text();
            return;
        }
    }

}



