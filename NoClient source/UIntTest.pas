unit UIntTest;
{Copyright 2001, Gary Darby, Intellitech Systems Inc., www.DelphiForFun.org

 This program may be used or modified for any non-commercial purpose
 so long as this original notice remains in place.
 All other rights are reserved
 }

interface

uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, Spin;

type
  TForm1 = class(TForm)
    Long1Edt: TEdit;
    Long2Edt: TEdit;
    AddBtn: TButton;
    MultBtn: TButton;
    FactorialBtn: TButton;
    SubtractBtn: TButton;
    DivideBtn: TButton;
    ModBtn: TButton;
    Memo1: TMemo;
    ComboBtn: TButton;
    procedure AddBtnClick(Sender: TObject);
    procedure MultBtnClick(Sender: TObject);
    procedure FactorialBtnClick(Sender: TObject);
    procedure SubtractBtnClick(Sender: TObject);
    procedure DivideBtnClick(Sender: TObject);
    procedure ModBtnClick(Sender: TObject);
    procedure ComboBtnClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  Form1: TForm1;

implementation
{$R *.DFM}
uses U_BigInts;

procedure TForm1.AddBtnClick(Sender: TObject);
{addition}
var
  i1,i2:Tinteger;
begin
  i1:=TInteger.create;
  i2:=TInteger.create;
  i1.assign(long1edt.text);
  i2.assign(long2Edt.text);
  i1.add(i2);
  memo1.text:=i1.converttoDecimalString(true);
  i1.free;
  i2.free;
end;

procedure TForm1.MultBtnClick(Sender: TObject);
{Multiply}
var
  i1,i2:Tinteger;
begin
  i1:=TInteger.create;
  i2:=TInteger.create;
  i1.assign(long1edt.text);
  i2.assign(long2Edt.text);
  i1.mult(i2);
  memo1.text:=i1.converttoDecimalString(true);
  i1.free;
  i2.free;
end;

procedure TForm1.FactorialBtnClick(Sender: TObject);
{Factorial}
var
  i1:Tinteger;
begin
  i1:=TInteger.create;
  i1.assign(long1edt.text);
  if i1.compare(1000)>0
  then
  begin
    showmessage('Input truncated to 1000');
    i1.assign(1000);
  end;
  i1.factorial;
  memo1.text:=i1.converttoDecimalString(true);
  i1.free;
end;

procedure TForm1.SubtractBtnClick(Sender: TObject);
{Subtraction}
var
  i1,i2:Tinteger;
begin
  i1:=TInteger.create;
  i2:=TInteger.create;
  i1.assign(long1edt.text);
  i2.assign(long2Edt.text);
  i1.subtract(i2);
  memo1.text:=i1.converttoDecimalString(true);
  i1.free;
  i2.free;
end;

procedure TForm1.DivideBtnClick(Sender: TObject);
{divide}
var
  i1,i2:Tinteger;
begin
  i1:=TInteger.create;
  i2:=TInteger.create;
  i1.assign(long1edt.text);
  i2.assign(long2Edt.text);
  i1.divide(i2);
  memo1.text:=i1.converttoDecimalString(true);
  i1.free;
  i2.free;
end;

procedure TForm1.ModBtnClick(Sender: TObject);
var
  i1,i2:Tinteger;
begin
  i1:=TInteger.create;
  i2:=TInteger.create;
  i1.assign(long1edt.text);
  i2.assign(long2Edt.text);
  i1.modulo(i2);
  memo1.text:=i1.converttoDecimalString(true);
  i1.free;
  i2.free;
end;

procedure TForm1.ComboBtnClick(Sender: TObject);
var
  i1,i2,i3:Tinteger;
begin
  i1:=TInteger.create;
  i2:=TInteger.create;
  i3:=TInteger.create;
  i1.assign(long1edt.text);
  i2.assign(long2Edt.text);
  if (i1.compare(100)<=0) and (i2.compare(100)<=0) then
  begin
    if i1.compare(i2)<0 then i1.assign(0)
    else if i1.compare(i2)=0 then i1.assign(1)
    else
    begin
      i3.assign(i1); i3.subtract(i2);
      i1.factorial;
      i2.factorial;
      i3.factorial;
      i1.divide(i2);
      i1.divide(i3);
    end;
    memo1.text:=i1.converttoDecimalString(true);
  end
  else showmessage('No calculation - numbers for combinations limited to 100');
  i1.free;
  i2.free;
  i3.free;
end;


end.
