unit U_BigInts;
{Copyright 2001, Gary Darby, Intellitech Systems Inc., www.DelphiForFun.org

 This program may be used or modified for any non-commercial purpose
 so long as this original notice remains in place.
 All other rights are reserved
 }

{ Arbitarily large integer unit -
  Operations supported:
    Assign, Add, Subtract, Multiply, Divide, Modulo, Compare, Factorial
   (Factorial limited to max integer, run time would probably limit it
    to much less)
   All operations are methods of a Tinteger class and replace the value with the
    result.  For binary operations (all except factorial), the second operand is
    passed as a parameter to the procedure.
 }

interface
  uses forms, dialogs;

type
  TDigits=array of byte;
  TInteger=class(TObject)
    private
     sign:integer;
     fdigits:TDigits;
     base:integer;
     procedure trim;
   public
     property digits:TDigits read fdigits;
     constructor  create;
     procedure Assign(Const I2:TInteger); overload;
     procedure Assign(Const I2:Int64); overload;
     procedure Assign(Const I2:string);overload;
     procedure absadd( const i2:tinteger);
     procedure Add(const I2:TInteger);overload;
     procedure Add(const I2:Int64); overload;
     procedure abssubtract(const i2:Tinteger);
     procedure Subtract(const I2:TInteger);overload;
     procedure Subtract(const I2:Int64); overload;
     procedure mult(const I2:TInteger); overload;
     procedure mult(const I2:int64); overload;
     procedure divide(const I2:TInteger); overload;
     procedure divide(const I2:Int64); overload;
     procedure modulo(const i2:TInteger); overload;
     procedure modulo(const i2:Int64); overload;
     procedure dividerem(const I2:TInteger; var remainder:TInteger);
     function compare(I2:TInteger):integer; overload;
     function compare(I2:Int64):integer; overload;
     function abscompare(I2:TInteger):integer;
     procedure factorial;
     function  ConvertToDecimalString(commas:boolean):String;
     function converttoInt64(var n:Int64):boolean;
  end;

implementation
uses math;

  constructor TInteger.create;
  begin
    inherited;
    base:=10; {base in Tinteger in case we want to handle other bases later}
    sign:=+1;
  end;

  procedure TInteger.trim;
  {trim leading zeros}
  var
    i:integer;
  begin
    i:=high(fdigits);
    while (i>0) and (fdigits[i]=0) do dec(i);
    setlength(fdigits,i+1);
  end;

  procedure TInteger.Assign(Const I2:TInteger);
  {Assign - TInteger}
  var
    i:integer;
  begin
    if i2.base=base then
    begin
      setlength(fdigits,length(i2.fdigits));
      for i:=low(i2.fdigits) to high(i2.fdigits) do fdigits[i]:=i2.fdigits[i];
      sign:=i2.sign;
      trim;
    end
    else
    begin
      showmessage('Bases other that 10 not yet supported');
    end;
  end;

  {************ Assign ***********}
  procedure TInteger.Assign(Const I2:Int64);
  {Assign - int64}
  var
    i:integer;
    n:int64;
  begin
    setlength(fdigits,20);
    n:=i2;
    i:=0;
    repeat
      fdigits[i]:=n mod base;
      n:=n div base;
      inc(i);
    until n=0;
    if i2<0 then sign:=-1
    else if i2=0 then sign:=0
    else if i2>0 then sign:=+1;
    setlength(fdigits,i);
    trim;
  end;

  procedure TInteger.Assign(const i2:string);
  {Assign - string number}
  var
    i,j:integer;
    zeroval:boolean;
  begin
    setlength(fdigits,length(i2));
    sign:=+1;
    j:=0;
    zeroval:=true;
    for i:=length(i2) downto 1 do
    begin
      if i2[i] in ['0'..'9'] then
      begin
        fdigits[j]:=ord(i2[i])-ord('0');
        if fdigits[j]<>0 then zeroval:=false;
        inc(j);
      end
      else if i2[i]='-' then sign:=-1;
    end;
    if zeroval then sign:=0;
    setlength(fdigits,j);
    trim;
  end;

  procedure TInteger.Add(Const I2:TInteger);
  {add - TInteger}
  begin
    if sign<>i2.sign then abssubtract(i2)
    else absadd(i2);
  end;


 procedure tinteger.absadd( const i2:tinteger);
 {add values ignoring signs}
 var
    i:integer;
    I3:Tinteger;
    n, carry:integer;
  begin
    I3:=TInteger.create;
    I3.assign(self);
    setlength(fdigits, max(length(fdigits),length(i2.fdigits))+1); {"add" could grow result by two digit}
    i:=0;
    carry:=0;
    while i<min(length(i2.fdigits),length(i3.fdigits)) do
    begin
      n:=i2.fdigits[i]+i3.fdigits[i]+carry;
      fdigits[i]:= n mod base;
      if n >= base then carry:=1 else carry:=0;
      inc(i);
    end;
    if length(i2.fdigits)>length(i3.fdigits) then
    while i<{=}length(i2.fdigits) do
    begin
      {
      fdigits[i]:=i2.fdigits[i]+carry;
      carry:=0;
      }
      n:=i2.fdigits[i]+carry;
      fdigits[i]:= n mod base;
      if n >= base then carry:=1 else carry:=0;
      inc(i);
    end
    else
    if length(i3.fdigits)>length(i2.fdigits) then
    begin
      while i<{=}length(i3.fdigits) do
      begin
        (*
        fdigits[i]:=i3.fdigits[i]+carry;
        carry:=0;
        *)
        n:=i3.fdigits[i]+carry;
        fdigits[i]:= n mod base;
        if n >= base then carry:=1 else carry:=0;
        inc(i)
      end;
      {fdigits[i]:=carry;}
    end
    ;{else} fdigits[i]:=carry;
    trim;
    i3.free;
  end;


  procedure TInteger.add(Const I2:Int64);
  {Add - Int64}
  var
    I3:TInteger;
  begin
    I3:=TInteger.create;
    I3.assign(I2);
    Add(I3);
    I3.free;
  end;

  procedure TInteger.Subtract(const I2:TInteger);
  {Subtract}
  begin
    if sign<>i2.sign then absadd(I2)
    else abssubtract(i2);
  end;


procedure TInteger.abssubtract(const i2:Tinteger);
{Subtract values ignoring signs}
var
    c:integer;
    i3:TInteger;
    i,j,k:integer;
  begin {request was subtract and signs are same,
         or request was add and signs are different}
    c:=abscompare(i2);
    i3:=TInteger.create;
    if c<0 then {abs(i2) larger, swap and subtract}
    begin
      i3.assign(self);
      assign(i2);
    end
    else if c>=0 then {self is bigger} i3.assign(i2);
    for i:= 0 to high(i3.fdigits) do
    begin
      if fdigits[i]>=i3.fdigits[i] then fdigits[i]:=fdigits[i]-i3.fdigits[i]
      else
      begin  {have to "borrow"}
        j:=i+1;
        while(j<=high(fdigits)) and (fdigits[j]=0) do inc(j);
        if j<=high(fdigits) then
        begin
          for k:=j downto i+1 do
          begin
            dec(fdigits[k]);
            fdigits[k-1]:=fdigits[k-1]+base;
          end;
          fdigits[i]:=fdigits[i]-i3.fdigits[i];
        end
          else showmessage ('Subtract error');
      end;
    end;
    i3.free;
    trim;
  end;


  procedure TInteger.Subtract(const I2:Int64);
  {subtract - TInteger}
  var
    I3:Tinteger;
  begin
    i3:=TInteger.create;
    i3.assign(i2);
    subtract(i3);
    i3.free;
  end;


  procedure TInteger.mult(const I2:TInteger);
  {Multiply - by Tinteger}
  var
    i3,i4:TInteger;  {for interim result}
    n:int64;
    i,j:integer;
  begin
    i3:=TInteger.create;
    i3.assign(0);
    i4:=Tinteger.create;
    for i:=0 to high(i2.fdigits) do
    begin
      n:=i2.fdigits[i];
      i4.assign(self);
      i4.mult(n);
      setlength(i4.fdigits,length(i4.fdigits)+i);
      if i>0 then
      begin
        for j:= high(i4.fdigits) downto i
        do i4.fdigits[j]:=i4.fdigits[j-i];
        for j:= i-1 downto 0
        do i4.fdigits[j]:=0;
      end;
      i3.add(i4);
    end;
    assign(i3); {assign also trims any leading zeros}
    if sign<>i2.sign then sign:=-1 else sign:=+1;
    i3.free;
    i4.free;
  end;

  procedure TInteger.mult(const I2:int64);
  {Multiply - by int64}
  var
    n,d:int64;
    carry:int64;
    i:integer;
  begin
    carry:=0;
    for i:=0 to high(fdigits) do
    begin
      n:=fdigits[i]*i2;
      d:=n mod base + carry;
      carry:=n div base;
      while d>=base do
      begin
       d:=d-base;
       inc(carry);
      end;
      fdigits[i]:=d;
    end;
    if carry<>0 then
    begin
      i:=high(fdigits)+1;
      setlength(fdigits,length(fdigits)+carry div base + 1);
      while carry>0 do
      begin
        fdigits[i]:=carry mod base;
        carry:=carry div base;
        inc(i);
      end;
    end;
    trim;
  end;

procedure TInteger.divide(const I2:TInteger);
{Divide - by TInteger}
var
  i3:TInteger;
  q:byte;
  i,size:integer;
  d:array of byte;
  pos:integer;
begin
  i3:=TInteger.create;
  dividerem(I2,i3);
  i3.free;
end;

procedure Tinteger.modulo(const i2:TInteger);
{Modulo (remainder after division) - by Tinteger}
var
  i3:TInteger;
begin
  i3:=TInteger.create;
  dividerem(i2,i3);
  assign(i3);
  i3.free;
end;

procedure TInteger.modulo(const I2:Int64);
{Modulo - by Int64}
var
  i3:Tinteger;
begin
  i3:=TInteger.create;
  i3.assign(i2);
  modulo(i3);
  i3.free;
end;

procedure TInteger.dividerem(const I2:TInteger; var remainder:TInteger);
{Divide - by TInteger and return remainder as well}
var
  i3:TInteger;
  q:byte;
  i,size:integer;
  d:array of byte;
  pos:integer;
  signout:integer;
  done:boolean;
begin
  if sign<>i2.sign then signout:=-1 else signout:=+1;
  sign:=+1;
  i2.sign:=+1;
  if compare(i2)>=0 then
  begin
    i3:=TInteger.create;
    setlength(i3.fdigits, length(i2.fdigits));
    pos:=high(fdigits);
    i3.assign(fdigits[pos]);
    dec(pos);
    size:=-1;
    if pos=-1 then{1 digit number}
    begin
      while i3.compare(i2)>=0 do
      begin
        inc(q);
        i3.subtract(i2);
      end;
      inc(size);
      setlength(d,1);
      d[size]:=q;
    end
    else
    while pos>=0 do
    begin
     done:=not ((pos>=0) and (i3.compare(i2)<0));
      while not done do { do}
      begin
        i3.mult(base);
        i3.add(fdigits[pos]);
        dec(pos);
        if (pos>=0) and (i3.compare(i2)<0) then
        begin
          inc(size);
          if size>length(d)-1 then setlength(d,length(d)+10);
          d[size]:=0;
        end
        else done:=true;
      end;
      q:=0;
      while i3.compare(i2)>=0 do
      begin
        inc(q);
        i3.subtract(i2);
      end;
      inc(size);
      if size>length(d)-1 then setlength(d,length(d)+10);
      d[size]:=q;
    end;

    setlength(fdigits, size+1);
    for i:= size downto 0 do
    fdigits[size-i]:=d[i];
    remainder.assign(i3);
    sign:=signout;
    remainder.sign:=signout;
    trim;
    i3.free;
  end
  else
  begin
    remainder.assign(self);
    assign(0);
  end;
end;



procedure TInteger.divide(const I2:Int64);
{Divide - by Int64}
var
  i3:Tinteger;
begin
  i3:=TInteger.create;
  i3.assign(i2);
  divide(i3);
  i3.free;
end;

function TInteger.compare(i2:TInteger):integer;
{Compare - to Tinteger}
{return +1 if self>i2, 0 if self=i2 and -1 if self<i2)}
begin
  if (sign<0) and (i2.sign>0) then result:=-1
  else if (sign>0) and (i2.sign<0) then result:=+1
  else {same sign} result:=abscompare(i2);
end;


function TInteger.compare(i2:Int64):integer;
{Compare - to int64}
{return +1 if self>i2, 0 if self=i2 and -1 if self<i2)}
var
  i3:TInteger;
begin
  i3:=TInteger.create;
  i3.assign(i2);
  if (sign<0) and (i3.sign>0) then result:=-1
  else if (sign>0) and (i3.sign<0) then result:=+1
  else {same sign} result:=abscompare(i3);
  i3.free;
end;


function TInteger.abscompare(i2:Tinteger):integer;
{compare absolute values ingoring signs - to Tinteger}
var
  i:integer;
begin
  result:=0;
  if length(fdigits)>length(i2.fdigits) then result:=+1
  else if length(fdigits)<length(i2.fdigits) then result:=-1
  else {equal length}
  for i:=high(fdigits) downto 0 do
  begin
    if fdigits[i]>i2.fdigits[i] then
    begin
      result:=+1;
      break;
    end
    else
    if fdigits[i]<i2.fdigits[i] then
    begin
      result:=-1;
      break;
    end;
  end;
end;

procedure TInteger.factorial;
{Compute factorial - number must be less than max integer value}
var
  n:int64;
  i:integer;
begin
  n:=0;
  if (compare(high(integer))>=0) or (sign<0) then exit;
  if compare(0)=0 then
  begin  {0! =1 by definition}
    assign(1);
    exit;
  end;
  for i:= high(fdigits) downto 0 do
  begin
    n:=n*base+fdigits[i];
  end;
  dec(n);
  while n>1 do
  begin
   mult(n);
   dec(n);
   {provide a chance to cancel long running ops}
   if (n mod 64) =0
   then application.processmessages;
  end;
end;


Function TInteger.ConvertToDecimalString(commas:boolean):string;
{Convert Tinteger to decimal string, insert commas if "commas" is true}
  var
    i:integer;
  begin
    result:='';
    for i:=0 to high(fdigits) do
    begin
      result:=char(ord('0')+fdigits[i])+result;
      if commas and((i mod 3)=2) and (i<high(fdigits)) then result:=','+result;
    end;
    if result='' then result:='0'
    else if sign<0 then result:='-'+result;
  end;

  function TInteger.converttoInt64(var n:Int64):boolean;
  var i:integer;
  begin
    result:=false;
    if high(fdigits)<=20 then
    begin
      n:=0;
      for i :=high(fdigits) downto 0  do n:=10*n+fdigits[i];
    end;
  end;
  
end.
