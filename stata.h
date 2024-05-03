#ifndef STATA_H
#define STATA_H

#include <QDialog>

namespace Ui {
class stata;
}

class stata : public QDialog
{
    Q_OBJECT

public:
    explicit stata(QWidget *parent = nullptr);
    ~stata();

private slots:
    void on_pushButton_clicked();

private:
    Ui::stata *ui;
};

#endif // STATA_H
