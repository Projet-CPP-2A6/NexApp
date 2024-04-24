#ifndef CHRIF_H
#define CHRIF_H

#include <QDialog>
#include"client.h"
namespace Ui {
class chrif;
}

class chrif : public QDialog
{
    Q_OBJECT

public:
    explicit chrif(QWidget *parent = nullptr);
    ~chrif();

private slots:
    void on_pushButton_8_clicked();

    void on_pushButton_10_clicked();

    void on_pushButton_9_clicked();

    void on_pushButton_11_clicked();

    void on_pushButton_12_clicked();



    void on_lineEdit_textEdited(const QString &arg1);

    void on_pushButton_13_clicked();

    void on_pushButton_16_clicked();

private:
    Ui::chrif *ui;
    Client l;
};

#endif // CHRIF_H
