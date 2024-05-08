#include "nour.h"
#include "ui_nour.h"
#include <QMessageBox>
#include <QPdfWriter>
#include <QPrinter>
#include <QPainter>
#include <QSqlQueryModel>
#include <QFileDialog>
#include "arduino.h"
#include <QPageSize>
#include "employe.h"

nour::nour(QWidget *parent)
    : QDialog(parent)
    , ui(new Ui::nour)
{
    ui->setupUi(this);
    int ret=A.connect_arduino();

    switch(ret){
    case(0):qDebug()<<"arduino is available and connected to :" << A.getarduino_port_name();
        break;
    case(1):qDebug()<<"arduino is  not available and not connected to :" << A.getarduino_port_name();
        break;

    case(-1):qDebug()<<"arduino is  not available";
    }

    QObject::connect(A.getserial(), SIGNAL(readyRead()), this, SLOT(update_label()));

    selectedCIN = -1;
     ui->tableView->setModel(e->afficher());

    connect(ui->tableView, &QAbstractItemView::clicked, this, &nour::handleItemClicked);
   /* connect(ui->search, &QLineEdit::textChanged, this, &nour::recherchecin);*/
}

nour::~nour()
{
    delete ui;
}

void nour::handleItemClicked(const QModelIndex &index)
{
    selectedIndex = index;
}



void nour::on_pushButton_8_clicked()
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
        ui->tabWidget->setCurrentIndex(2);
    }

    else {
        // Erreur lors de l'ajout de l'employé
        QMessageBox::critical(this, "Erreur", "Échec de l'ajout de l'employé.");
    }


}



void nour::on_pushButton_9_clicked()
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



void nour::on_tableView_clicked(const QModelIndex &index)
{
    // Get the selected row's data
    int row = index.row();
    // Store the CIN of the selected employee
    selectedCIN = ui->tableView->model()->index(row, 4).data().toInt();
}





void nour::on_tabWidget_currentChanged(int index)
{
    if (index == 2) {
        //clear_chart_widget();
        //chart_render();
        ui->tabWidget->setCurrentIndex(2);
        ui->tableView->setModel(e->afficher());
}
}









void nour::on_lineEdit_2_textEdited(const QString &searchText)
{
     ui->tableView->setModel(e->recherche_cin(searchText));
}


void nour::on_pushButton_23_clicked()
{
    ui->tableView->sortByColumn(0, Qt::AscendingOrder);

}


void nour::on_pushButton_21_clicked()
{

    // Get the file path where the user wants to save the PDF
    QString filePath = QFileDialog::getSaveFileName(this, tr("Save File"), "", tr("PDF Files (*.pdf)"));

    if (filePath.isEmpty()) {
        return; // User canceled the dialog
    }

    // Create a QPrinter object
    QPrinter printer;
    printer.setOutputFormat(QPrinter::PdfFormat);

    // Set the output file name
    printer.setOutputFileName(filePath);

    // Create a QPainter object
    QPainter painter;
    if (!painter.begin(&printer)) {
        QMessageBox::critical(this, tr("Error"), tr("Failed to create PDF painter."));
        return;
    }

    // Formatting settings (adjust as needed)
    QFont font("Arial", 10);
    painter.setFont(font);
    int cellWidth = 100;
    int cellHeight = 20;

    // Get the table model
    QAbstractItemModel *model = ui->tableView->model();

    // Check if the model is valid and has data
    if (!model || model->rowCount() == 0) {
        QMessageBox::warning(this, tr("Error"), tr("No data to export. Please ensure your table has data."));
        painter.end();
        return;
    }

    // Get table dimensions
    int rows = model->rowCount();
    int columns = model->columnCount();

    // Draw column headers
    for (int col = 0; col < columns; ++col) {
        QString header = model->headerData(col, Qt::Horizontal).toString();
        painter.drawText(col * cellWidth, 0, cellWidth, cellHeight, Qt::AlignCenter, header);
        painter.drawLine(col * cellWidth, 0, col * cellWidth, rows * cellHeight);
    }

    // Draw table data
    for (int row = 0; row < rows; ++row) {
        for (int col = 0; col < columns; ++col) {
            QModelIndex index = model->index(row, col);
            QString data = model->data(index).toString();
            painter.drawText(col * cellWidth, (row + 1) * cellHeight, cellWidth, cellHeight, Qt::AlignLeft, data);
        }
        painter.drawLine(0, (row + 1) * cellHeight, columns * cellWidth, (row + 1) * cellHeight);
    }

    painter.end();

    QMessageBox::information(this, tr("Success"), tr("PDF file saved successfully!"));

}


void nour::on_pushButton_22_clicked()
{
    /*chart_render();*/
    ui->tabWidget->setCurrentIndex(2);
    ui->tableView->setModel(e->afficher());

}


