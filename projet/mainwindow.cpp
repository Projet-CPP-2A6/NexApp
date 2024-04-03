#include "mainwindow.h"
#include "ui_mainwindow.h"

MainWindow::MainWindow(QWidget *parent)
    : QMainWindow(parent)
    , ui(new Ui::MainWindow)
{
    ui->setupUi(this);
    selectedCIN = -1;
    connect(ui->tableView, &QAbstractItemView::clicked, this, &MainWindow::handleItemClicked);
    connect(ui->search, &QLineEdit::textChanged, this, &MainWindow::recherchecin);
}

MainWindow::~MainWindow()
{
    delete ui;
}
void MainWindow::handleItemClicked(const QModelIndex &index)
{
    selectedIndex = index;
}
void MainWindow::on_modifier_clicked()
{
    if (selectedIndex.isValid()) {
        int row = selectedIndex.row();
        int cin = ui->tableView->model()->index(row, 4).data().toInt();
        QString nom = ui->tableView->model()->index(row, 0).data().toString();
        QString prenom = ui->tableView->model()->index(row, 1).data().toString();
        QString email = ui->tableView->model()->index(row, 2).data().toString();
        QString fonction = ui->tableView->model()->index(row, 6).data().toString();
        QDate deb = ui->tableView->model()->index(row, 7).data().toDate();
        float salaire = ui->tableView->model()->index(row, 3).data().toFloat();
        int numero = ui->tableView->model()->index(row, 5).data().toInt();

        // Populate the fields in the stacked widget with the data of the selected row
        ui->cin_2->setText(QString::number(cin));
        ui->cin_2->setReadOnly(true);
        ui->nom_2->setText(nom);
        ui->prenom_2->setText(prenom);
        ui->fonction_2->setText(fonction);
        ui->deb_2->setDate(deb);
        ui->deb_2->setReadOnly(true);
        ui->numero_2->setText(QString::number(numero));
        ui->salaire_2->setText(QString::number(salaire));
        ui->email_2->setText(email);
        ui->tabWidget->setCurrentIndex(1);
    } else {
        qDebug() << "No row selected.";
    }
}
void MainWindow::recherchecin(const QString &searchText) {
    ui->tableView->setModel(e->recherche_cin(searchText));
}
void MainWindow::on_modifiernour_clicked()
{
    int cin=ui->cin_2->text().toInt();
    QString nom=ui->nom_2->text();
    QString prenom=ui->prenom_2->text();
    QDate de=ui->deb_2->date();
    QString email=ui->email_2->text();
    int numero= ui->numero_2->text().toInt();
    float salaire= ui->salaire_2->text().toFloat();
    QString fonction= ui->fonction_2->text();

    if (e->Modifier_element(cin,de,numero,nom,prenom,email,fonction,salaire)) {
        ui->cin_2->clear();
        ui->nom_2->clear();
        ui->prenom_2->clear();
        ui->email_2->clear();
        ui->numero_2->clear();
        ui->salaire_2->clear();
        ui->deb_2->clearMask();
        ui->fonction_2->clearMask();
        ui->tabWidget->setCurrentIndex(2);
    } else {
        qDebug() << "Failed to modify";
    }
}
void MainWindow:: on_ajouter_clicked()
{
    int cin=ui->cin->text().toInt();
    QString nom=ui->nom->text();
    QString prenom=ui->prenom->text();
    QDate de=ui->de->date();
    QString email=ui->email->text();
    int numero= ui->numero->text().toInt();
    float salaire= ui->salaire->text().toFloat();
    QString fonction= ui->fonction->text();

    if (e-> AjouterEmploye(cin,de,numero,nom,prenom,email,fonction,salaire)) {
        ui->cin->clear();
        ui->nom->clear();
        ui->prenom->clear();
        ui->email->clear();
        ui->salaire->clear();
        ui->de->clearMask();
        ui->fonction->clear();
        ui->numero->clear();
        //ui->stackedWidget->setCurrentIndex(0);
    }
}

void MainWindow::on_tabWidget_currentChanged(int index)
{
    if (index == 2) {
        ui->tabWidget->setCurrentIndex(2);
        ui->tableView->setModel(e->afficher());
    }
}
void MainWindow::on_tableView_clicked(const QModelIndex &index) {
    // Get the selected row's data
    int row = index.row();
    // Store the CIN of the selected employee
    selectedCIN = ui->tableView->model()->index(row, 4).data().toInt(); // Assuming CIN is in column 0
}

void MainWindow::on_supprimer_clicked() {
    // Check if a row is selected
    if(selectedCIN != -1) {
        // Delete the selected row from the database
        if (e->EffacerEmploye(selectedCIN)) { // Assuming EffacerEmploye returns true if deletion was successful
            // Delete the selected row from the interface
            ui->tableView->model()->removeRow(selectedCIN);

            // Reset selectedCIN to indicate no row is selected
            selectedCIN = -1;

            // Commit the transaction if needed
            QSqlDatabase::database().commit();
        } else {
            // Deletion from the database failed, handle error if needed
            qDebug() << "Failed to delete row from the database";
        }
    }
}
