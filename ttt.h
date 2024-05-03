#ifndef TTT_H
#define TTT_H

#include <QDialog>

namespace Ui {
class ttt;
}

class ttt : public QDialog
{
    Q_OBJECT

public:
    explicit ttt(QWidget *parent = nullptr);
    ~ttt();

private:
    Ui::ttt *ui;
};

#endif // TTT_H
