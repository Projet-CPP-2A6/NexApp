#include "interface.h"
#include "ui_interface.h"
#include <QPdfWriter>
#include <QPainter>
#include <QMessageBox>
#include <QTableView>
#include <QAbstractItemModel>
#include <QUrl>
#include <QDesktopServices>
#include <QGraphicsView>
#include <QGraphicsScene>
#include <QSqlQueryModel>
#include <QModelIndex>
#include "suppression.h"
#include"partenaire.h"
#include <QPdfWriter>
#include <QPrinter>
#include"add.h"
#include"modif.h"
#include "statistique.h"
#include "chat.h"
#include <QDoubleValidator>
#include <QDateTime>
#include <QSqlDatabase>
#include <QMenu>
#include <QSystemTrayIcon>
#include <QtSql>
#include <QDebug>



interface::interface(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::interface)
{
    ui->setupUi(this);
    ui->listEmployetableView->setModel(P.afficher());
    connect(ui->pushButton_17, &QPushButton::clicked, this, &interface::showNotification);
    QIcon icon("C:/Users/MSI/Pictures/png-transparent-red-bell-notification-thumbnail-removebg-preview.png"); // Spécifiez le chemin vers votre icône
    ui->pushButton_17->setIcon(icon); // Définissez l'icône sur votre bouton
    ui->pushButton_17->setIconSize(QSize(50, 50));

     // Créer une instance de la classe Partenaire

    // Charger les données des partenaires dans le tableau au démarrage de l'application


}

interface::~interface()
{
    delete ui;
}





void interface::on_pushButton_8_clicked()
{
    add a;
    a.exec();
}


void interface::on_pushButton_9_clicked()
{
    suppression s;
    s.exec();
}



void interface::on_pushButton_10_clicked()
{
    modif m;
    m.exec();

}


void interface::on_pushButton_11_clicked()
{

    Partenaire P;

    // Afficher les données dans le QTableView
    ui->listEmployetableView->setModel(P.afficher());
}


void interface::on_pushButton_12_clicked()
{
    // Configuration du QPrinter pour générer un PDF
    QPrinter printer;
    printer.setOutputFormat(QPrinter::PdfFormat);
    printer.setOutputFileName("C:\\Users\\MSI\\Desktop\\travailQt\\Integration\\listepartenaires.pdf");

    // Création d'un objet QPainter pour l'objet QPrinter
    QPainter painter;
    if (!painter.begin(&printer)) {
        qWarning("Failed to open file, is it writable?");
        return;
    }

    // Définition des styles
    QFont font("Arial", 7);
    painter.setFont(font);

    // Obtenir le modèle de la table à partir de la QTableView
    QAbstractItemModel *model = ui->listEmployetableView->model();

    // Obtenir les dimensions de la table
    int rows = model->rowCount();
    int columns = model->columnCount();

    // Définir la taille de la cellule pour le dessin
    int cellWidth = 100;
    int cellHeight = 40;

    // Insérer les noms des colonnes et dessiner des lignes verticales
    for (int col = 0; col < columns; ++col) {
        QString headerData = model->headerData(col, Qt::Horizontal).toString();
        painter.drawText(col * cellWidth, 0, cellWidth, cellHeight, Qt::AlignCenter, headerData);
        painter.drawLine(col * cellWidth, 0, col * cellWidth, rows * cellHeight); // Dessiner une ligne verticale
    }

    // Insérer les données de la table sur le périphérique de sortie PDF
    for (int row = 1; row < rows; ++row) {
        for (int col = 0; col < columns; ++col) {
            // Obtenir les données de la cellule
            QModelIndex index = model->index(row, col);
            QString data = model->data(index).toString();

            // Insérer les données de la cellule
            painter.drawText(col * cellWidth, row * cellHeight, cellWidth, cellHeight, Qt::AlignLeft, data);
        }
        // Dessiner une ligne horizontale après chaque ligne de données
        painter.drawLine(0, row * cellHeight, columns * cellWidth, row * cellHeight);
    }

    // Terminer avec QPainter
    painter.end();

    // Afficher un QMessageBox pour indiquer que le fichier a été enregistré
    QMessageBox::information(this, "Enregistrement réussi", "La liste a été enregistrée. Merci de consulter votre dossier.");
}


void interface::on_pushButton_13_clicked()
{
    // Créez une instance de la classe partenaire
    Partenaire partenaire;

    // Appeler la fonction TriPar pour obtenir le modèle de requête SQL trié
    QSqlQueryModel* model = partenaire.TriPar("NOM_ENTREPRISE");

    if (model) {
        // Afficher le modèle de requête SQL dans le QTableView
        ui->listEmployetableView->setModel(model);
    } else {
        // Afficher un message d'erreur si le modèle est nul
        QMessageBox::warning(this, "Erreur", "Impossible de trier les données.");
    }

}


void interface::on_lineEdit_textEdited(const QString &searchText)
{
    bool rechercheParMatricule = searchText.length() <= 5; // Si la longueur de la chaîne de recherche est inférieure ou égale à 10, on suppose que c'est un matricule fiscal

    // Appeler la fonction de recherche appropriée
    ui->listEmployetableView->setModel(p.recherche(searchText, rechercheParMatricule));

}




void interface::on_pushButton_16_clicked()
{
    statistique t;
    t.exec();
}


void interface::on_pushButton_15_clicked()
{
    chat c;
    c.exec();

}


/*void interface::showNotification()
{
    QSqlQuery query;
    query.prepare("SELECT * FROM FOOL WHERE FIN_CONTRAT BETWEEN '01/01/22' AND '28/04/24';");
    query.exec();

    QSystemTrayIcon trayIcon;
    trayIcon.setIcon(QIcon(":/new/prefix1/png-transparent-red-bell-notification-thumbnail.png"));
    trayIcon.setVisible(true);

    while (query.next()) {
        QString entreprise = query.value("NOM_ENTREPRISE").toString(); // Supposons que le nom de l'entreprise soit stocké dans une colonne NOM_ENTREPRISE
        QString dateFinContrat = query.value("FIN_CONTRAT").toString(); // Supposons que la date de fin de contrat soit stockée dans une colonne FIN_CONTRAT

        QString message = QString("Entreprise: %1\nDate de fin du contrat: %2").arg(entreprise).arg(dateFinContrat);

        trayIcon.showMessage("Nouvelle notification", message, QSystemTrayIcon::Information, 5000);

        // Vous pouvez créer le menu en dehors de la boucle si vous voulez un seul menu pour toutes les notifications
        QMenu *menu = new QMenu();
        menu->addAction("Bonjour");
        menu->addAction("Quitter");
        trayIcon.setContextMenu(menu);
    }




}*/


// Fonction pour comparer la date actuelle avec la date de fin de contrat

bool compareDates(const QDateTime &currentDate, const QDateTime &endDate) {
    return currentDate > endDate;
}

void interface::showNotification() {
    QSqlQuery query;
    if (!query.exec("SELECT * FROM FOOL WHERE FIN_CONTRAT BETWEEN '01/01/22' AND '28/04/24';")) {
        qDebug() << "Error executing query:" << query.lastError();
        return;
    }

    QSystemTrayIcon trayIcon;
    trayIcon.setIcon(QIcon(":/new/prefix1/png-transparent-red-bell-notification-thumbnail.png"));
    trayIcon.setVisible(true);

    QDateTime currentDate = QDateTime::currentDateTime();

    while (query.next()) {
        QString entreprise = query.value("NOM_ENTREPRISE").toString();
        QString dateFinContratStr = query.value("FIN_CONTRAT").toString();
        QDateTime dateFinContrat = QDateTime::fromString(dateFinContratStr, "dd/MM/yy");

        if (compareDates(currentDate, dateFinContrat)) {
            QString message = QString("Entreprise: %1\nDate de fin du contrat: %2").arg(entreprise).arg(dateFinContratStr);
            trayIcon.showMessage("Nouvelle notification", message, QSystemTrayIcon::Information, 5000);

            /*QMenu *menu = new QMenu();*/
            /*menu->addAction("Bonjour");
            menu->addAction("Quitter");*/
            /*trayIcon.setContextMenu(menu);*/
        }
    }
}





