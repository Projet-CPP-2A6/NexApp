#include "ajouch.h"
#include "ui_ajouch.h"
#include "client.h"
#include "chrif.h"


ajouch::ajouch(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::ajouch)
{
    ui->setupUi(this);
}

ajouch::~ajouch()
{
    delete ui;
}

void ajouch::on_pushButton_clicked()
{
    QString cin = ui->cin_LE->text();
    QString nom = ui->nom_LE->text();
    QString prenom = ui->prenom_LE->text();
    QString adresse = ui->adresse_LE->text();
    QString numeroTelephone = ui->numeroTelephone_LE->text();
    QString email = ui->email_LE->text();

    // Créer un objet client et l'ajouter
    Client client(cin, nom, prenom, adresse, numeroTelephone, email);
    bool test = client.ajouter();

    // Vérifier si l'ajout a réussi et afficher un message en conséquence
    if (test) {
        QMessageBox::information(this, "Succès", "Ajout effectué avec succès!");
    } else {
        QMessageBox::warning(this, "Erreur", "L'ajout n'a pas pu être effectué.");
    }
}

