object Form1: TForm1
  Left = 18
  Top = 32
  Width = 696
  Height = 480
  Caption = 'Test Big Integers unit'
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'MS Sans Serif'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object Long1Edt: TEdit
    Left = 96
    Top = 32
    Width = 401
    Height = 21
    TabOrder = 0
    Text = '12345678901234567890'
  end
  object Long2Edt: TEdit
    Left = 96
    Top = 112
    Width = 401
    Height = 21
    TabOrder = 1
    Text = '987654321987654321'
  end
  object AddBtn: TButton
    Left = 96
    Top = 72
    Width = 25
    Height = 25
    Caption = '+'
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'MS Sans Serif'
    Font.Style = []
    ParentFont = False
    TabOrder = 2
    OnClick = AddBtnClick
  end
  object MultBtn: TButton
    Left = 192
    Top = 72
    Width = 25
    Height = 25
    Caption = '*'
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'MS Sans Serif'
    Font.Style = []
    ParentFont = False
    TabOrder = 3
    OnClick = MultBtnClick
  end
  object FactorialBtn: TButton
    Left = 512
    Top = 32
    Width = 25
    Height = 25
    Hint = 'Factorials limited to 1000! (2568 digits)'
    Caption = '!'
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'MS Sans Serif'
    Font.Style = []
    ParentFont = False
    ParentShowHint = False
    ShowHint = True
    TabOrder = 4
    OnClick = FactorialBtnClick
  end
  object SubtractBtn: TButton
    Left = 144
    Top = 72
    Width = 25
    Height = 25
    Caption = '-'
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'MS Sans Serif'
    Font.Style = []
    ParentFont = False
    TabOrder = 5
    OnClick = SubtractBtnClick
  end
  object DivideBtn: TButton
    Left = 240
    Top = 72
    Width = 25
    Height = 25
    Caption = '/'
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -19
    Font.Name = 'MS Sans Serif'
    Font.Style = []
    ParentFont = False
    TabOrder = 6
    OnClick = DivideBtnClick
  end
  object ModBtn: TButton
    Left = 288
    Top = 72
    Width = 33
    Height = 25
    Caption = 'Mod'
    TabOrder = 7
    OnClick = ModBtnClick
  end
  object Memo1: TMemo
    Left = 96
    Top = 184
    Width = 420
    Height = 161
    Lines.Strings = (
      '')
    ScrollBars = ssVertical
    TabOrder = 8
  end
  object ComboBtn: TButton
    Left = 360
    Top = 72
    Width = 75
    Height = 25
    Caption = 'Combinations'
    TabOrder = 9
    OnClick = ComboBtnClick
  end
end
