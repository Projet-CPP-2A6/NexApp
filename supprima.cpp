#include "supprima.h"
#include "ui_supprima.h"
#include "aminee.h"
#include <QMessageBox>
#include"constat.h"

supprima::supprima(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::supprima)
{
    ui->setupUi(this);
}

supprima::~supprima()
{
    delete ui;
}

void supprima::on_pushButton_clicked()
{
    QString ID = ui->lineEdit_ID->text(); // Obtenez l'ID à partir de votre interface utilisateur

    // Créer un objet constat
    constat monConstat;

    // Appeler la fonction supprimer
    bool success = monConstat.supprimer(ID);

    // Vérifier si la suppression a réussi et afficher un message en conséquence
    if (success) {
        QMessageBox::information(this, "Succès", "Suppression du constat effectuée avec succès !");
    } else {
        QMessageBox::warning(this, "Erreur", "La suppression du constat n'a pas pu être effectuée.");
    }

}

