#include "pluss.h"
#include <QMessageBox>
#include "aminee.h"
#include "constat.h"
#include "ui_pluss.h"

pluss::pluss(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::pluss)
{
    ui->setupUi(this);
}

pluss::~pluss()
{
    delete ui;
}

void pluss::on_pushButton_clicked()
{

    QString ID = ui->lineEdit_ID->text();
    QString dateConstat = ui->lineEdit_dateConstat->text();
    QString lieuConstat = ui->lineEdit_lieuConstat->text();
    QString typeConstat = ui->lineEdit_typeConstat->text();
    QString description = ui->plainTextEdit_description->toPlainText();
    QString signature = ui->lineEdit_signature->text();

    // Si les champs obligatoires sont vides, afficher un message d'avertissement


    // Création d'un nouvel objet constat
    constat nouveauConstat(ID, dateConstat, lieuConstat, typeConstat, description, signature);

    // Appel de la fonction d'ajout
    bool test = nouveauConstat.ajouter();

    if (test) {
        QMessageBox::information(this, "Succès", "Ajout effectué avec succès!");
    } else {
        QMessageBox::warning(this, "Erreur", "L'ajout n'a pas pu être effectué.");
    }

}

