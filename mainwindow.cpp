#include "mainwindow.h"
#include "ui_mainwindow.h"
#include <QPageSize>

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


void MainWindow::on_pdf_clicked()
{

    QString filePath = QFileDialog::getSaveFileName(this, tr("Save PDF"), "", tr("PDF Files (*.pdf)"));

    if (!filePath.isEmpty()) {
        QFile file(filePath);
        if (!file.open(QIODevice::WriteOnly)) {
            QMessageBox::warning(this, tr("Error"), tr("Could not create file."));
            return;
        }
        QPrinter printer;
        printer.setOutputFormat(QPrinter::PdfFormat);

        // Set page size to A4
        QPageSize pageSize(QPageSize::A4);
        printer.setPageSize(pageSize);

        printer.setOutputFileName(filePath);

        QPainter painter;
        if (!painter.begin(&printer)) {
            QMessageBox::warning(this, tr("Error"), tr("Could not create painter."));
            return;
        }

        int x = 100;
        int y = 100;
        int cw = 100;
        int rowHeight = 20;
        QStringList h;
        int nl = ui->tableView->model()->rowCount();
        int nc = ui->tableView->model()->columnCount();
        for (int i = 0; i < nl; ++i) {
            for (int j = 0; j < nc; ++j) {
                QString data = ui->tableView->model()->index(i, j).data(Qt::DisplayRole).toString();
                painter.drawText(x + j * cw, y + (i + 1) * rowHeight, data);
            }
        }

        painter.end();

        QMessageBox::information(this, tr("Success"), tr("PDF file saved successfully"));
    }
}

void MainWindow::history(int userID, bool userAdded) {
    QFile file("C:/Users/Sarwir/Bureau/history.txt");
    if (!file.open(QIODevice::Append | QIODevice::Text)) {
        qDebug() << "Failed to open file for writing:" << file.errorString();
        return;
    }
    QTextStream out(&file);
    QString action = userAdded ? "added" : "deleted";
    QDateTime currentTime = QDateTime::currentDateTime();
    out << currentTime.toString(Qt::ISODate) << " - User ID '" << userID << "' was " << action << ".\n";
    file.close();
}
void MainWindow::on_tri_clicked()
{
    ui->tableView->sortByColumn(0, Qt::AscendingOrder);
}
void MainWindow::chart_render() {
    clear_chart_widget();
    QSqlQuery query;
    query.prepare("SELECT SALAIRE FROM EMPLOYE");
    if (!query.exec()) {
        qDebug() << "Error executing query:" << query.lastError().text();
        return;
    }
    int total = 0;
    int number1 = 0; // 600-1000
    int number2 = 0; // 1000-3000
    int number3 = 0; // above 3000
    while (query.next()) {
        float salaire = query.value(0).toFloat();
        if (salaire >= 600 && salaire <= 1000)
            number1++;
        else if (salaire > 1000 && salaire <= 3000)
            number2++;
        else if (salaire > 3000)
            number3++;
        total++;
    }
    QPieSeries *series = new QPieSeries();
    series->append("600-1000", number1);
    series->append("1000-3000", number2);
    series->append("sup3000", number3);

    // Calculate percentages
    qreal percent1 = (qreal)number1 / total * 100;
    qreal percent2 = (qreal)number2 / total * 100;
    qreal percent3 = (qreal)number3 / total * 100;

    QChart *chart = new QChart();
    chart->addSeries(series);
    chart->setTitle("Salaires");
    chart->legend()->setVisible(true);
    chart->legend()->setFont(QFont("MS Shell Dig2", 7));
    chart->setBackgroundBrush(QColor("#FFFFFF"));

    // Create custom label for displaying percentage
    QString label1 = QString(" %1%").arg(percent1, 0, 'f', 2);
    QString label2 = QString(" %1%").arg(percent2, 0, 'f', 2);
    QString label3 = QString(" %1%").arg(percent3, 0, 'f', 2);

    series->setLabelsVisible(true);
    series->setLabelsPosition(QPieSlice::LabelOutside);
    series->slices().at(0)->setLabel(label1);
    series->slices().at(1)->setLabel(label2);
    series->slices().at(2)->setLabel(label3);

    QChartView *chartView = new QChartView(chart);
    chartView->setRenderHint(QPainter::Antialiasing);

    // Clear existing layout
    if (ui->donut->layout()) {
        QLayoutItem *child;
        while ((child = ui->donut->layout()->takeAt(0)) != nullptr) {
            if (child->widget()) {
                delete child->widget(); // Delete widget from layout
            }
            delete child; // Delete layout item
        }
    }

    // Create new layout and add chart view to it
    QVBoxLayout *layout = new QVBoxLayout(ui->donut);
    layout->addWidget(chartView);
}


void MainWindow::clear_chart_widget() {
    QLayout *donutLayout = ui->donut->layout();
    if (donutLayout) {
        QLayoutItem *item;
        while ((item = donutLayout->takeAt(0)) != nullptr) {
            if (QWidget *widget = item->widget()) {
                delete widget;
            }
            delete item;
        }
        delete donutLayout;
    }
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
void MainWindow::on_ajout2_clicked(){
     ui->tabWidget->setCurrentIndex(0);
}
void MainWindow::on_envoyer_email_clicked() {
    mailer::sendEmail(ui->destinataireEmail->text(), ui->objetEmail->text(),
                      ui->bodyEmail->text());
}
void MainWindow:: on_ajouter_clicked()
{

    int cin=ui->cin->text().toInt();
    history(cin, true);
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
}

void MainWindow::on_tabWidget_currentChanged(int index)
{
    if (index == 2) {
        clear_chart_widget();
        chart_render();
        ui->tabWidget->setCurrentIndex(2);
        ui->tableView->setModel(e->afficher());
    }
}
void MainWindow::on_tableView_clicked(const QModelIndex &index) {
    int row = index.row();
    selectedCIN = ui->tableView->model()->index(row, 4).data().toInt();
}
void MainWindow::on_refresh_clicked(){

    chart_render();
    ui->tabWidget->setCurrentIndex(2);
    ui->tableView->setModel(e->afficher());
}

void MainWindow::on_supprimer_clicked() {
    if(selectedCIN != -1) {
        if (e->EffacerEmploye(selectedCIN)) {
            history(selectedCIN, false);
            ui->tableView->model()->removeRow(selectedCIN);
            selectedCIN = -1;
            QSqlDatabase::database().commit();
        } else {
            qDebug() << "Failed to delete row from the database";
        }
    }
}
