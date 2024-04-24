#ifndef AMINEE_H
#define AMINEE_H

#include <QDialog>
#include "constat.h"

namespace Ui {
class aminee;
}

class aminee : public QDialog
{
    Q_OBJECT

public:
    explicit aminee(QWidget *parent = nullptr);
    ~aminee();

private slots:
    void on_pushButton_8_clicked();

    void on_pushButton_10_clicked();

    void on_pushButton_9_clicked();

    void on_pushButton_12_clicked();

    void on_pushButton_13_clicked();

    void on_pushButton_11_clicked();

    void on_lineEdit_textEdited(const QString &arg1);

    void on_pushButton_16_clicked();

private:
    Ui::aminee *ui;
    constat c;

};

#endif // AMINEE_H
