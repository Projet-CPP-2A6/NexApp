#include "modifch.h"
#include "ui_modifch.h"
#include"client.h"

modifch::modifch(QWidget *parent) :
    QDialog(parent),
    ui(new Ui::modifch)
{
    ui->setupUi(this);
}

modifch::~modifch()
{
    delete ui;
}

void modifch::on_pushButton_clicked()
{
    QString cin = ui->lineEdit_ID->text();
    QString nouveauNumeroTelephone = ui->lineEdit_nouveauNumeroTelephone->text();
    QString nouvelleAdresse = ui->lineEdit_nouvelleAdresse->text();
    QString nouvelEmail = ui->lineEdit_nouvelEmail->text();

    // Créer un objet client
    Client monClient;

    // Appeler la fonction modifierClient
    bool success = monClient.modifier(cin,nouvelleAdresse, nouveauNumeroTelephone, nouvelEmail);

    // Afficher un message en fonction du succès de l'opération
    if (success) {
        QMessageBox::information(this, "Succès", "Modification du client réussie !");
    } else {
        QMessageBox::warning(this, "Erreur", "La modification du client n'a pas pu être effectuée.");
    }
}

