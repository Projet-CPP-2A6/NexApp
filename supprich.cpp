#include "supprich.h"
#include "ui_supprich.h"
#include "client.h"

supprich::supprich(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::supprich)
{
    ui->setupUi(this);
}

supprich::~supprich()
{
    delete ui;
}

void supprich::on_pushButton_clicked()
{
    QString cin = ui->lineEdit_ID->text(); // Obtenez le CIN à partir de votre interface utilisateur

    // Créer un objet client
    Client monClient;

    // Appeler la fonction supprimer
    bool success = monClient.supprimer(cin);

    // Vérifier si la suppression a réussi et afficher un message en conséquence
    if (success) {
        QMessageBox::information(this, "Succès", "Suppression du client effectuée avec succès !");
    } else {
        QMessageBox::warning(this, "Erreur", "La suppression du client n'a pas pu être effectuée.");
    }
}

