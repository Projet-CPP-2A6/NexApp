#include "suppression.h"
#include "ui_suppression.h"
#include <QMessageBox>
#include "partenaire.h"

suppression::suppression(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::suppression)
{
    ui->setupUi(this);
}

suppression::~suppression()
{
    delete ui;
}

void suppression::on_pushButton_clicked()
{
     QString matriculeFiscale = ui->matriculeFiscale_LE->text(); // Obtenez le nom à partir de votre interface utilisateur

    Partenaire etemp;
    bool test = etemp.supprimer(matriculeFiscale);

    // Vérifier si la suppression a réussi et afficher un message en conséquence
    if (test) {
        QMessageBox::information(this, "Succès", "Suppression effectuée avec succès!");
    } else {
        QMessageBox::warning(this, "Erreur", "La suppression n'a pas pu être effectuée.");
    }
}


void suppression::on_pushButton_3_clicked()
{
    this->close();

}

