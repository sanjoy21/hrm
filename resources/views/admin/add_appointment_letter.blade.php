@extends('admin.index')

@section('title')
    Add Appointment Letter
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Appointment Letter</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add Appointment Letter</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">

                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('error') }}
                                </div>
                            @endif

                            <div class="card-header">
                                <h3 class="card-title">Appointment Letter</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ route('appointment_letter_add_store') }}" method="post">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group col-md-4">
                                        <label>Date</label>
                                        <input type="date" name="date" class="form-control">
                                        @error('date')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Full Name">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-12" id="printArea">
                                        <label>Appointment Letter</label>
                                        <textarea name="letter" id="compose-textarea" class="form-control">



<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt"><b style="mso-bidi-font-weight:normal"><span style="mso-bidi-font-size:10.0pt;
line-height:115%;font-family:" arial",sans-serif"="">RKSBD/HR/20250301-03<span style="mso-spacerun:yes">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </span></span></b>Date: 26/02/2025</p>

<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">&nbsp;</p>

<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">&nbsp;</p>

<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">[Full Name]<span style="mso-spacerun:yes">&nbsp;</span></p>

<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">Address:</p><p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">Mobile: 01XXXXXXXXX</p>

<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">E-mail: example@gmail.com</p>

<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">&nbsp;</p>

<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">&nbsp;</p>

<p class="MsoNormal" align="center" style="text-align:center"><b style="mso-bidi-font-weight:
normal"><span style="font-size:12.0pt;line-height:115%">SUBJECT: <u>Appointment
Letter</u></span></b></p>

<p class="MsoNormal" style="text-align:justify;text-justify:inter-ideograph">With
reference to your bio-data submitted to us and the subsequent interview held
for Contractual Employment as an <b>[Designation Here] </b>in <b style="mso-bidi-font-weight:normal">RK Software (Bangladesh)
Limited</b>, we are pleased to offer you <b style="mso-bidi-font-weight:normal">Contractual
Employment from <span style="background:yellow;mso-highlight:yellow">1<sup>st</sup>
<span style="mso-spacerun:yes">&nbsp;</span>March 2025</span> </b>on the following
terms &amp; conditions.</p>

<ol style="margin-top:0in" start="1" type="1"><li class="MsoNormal" style="margin-top:6.0pt;margin-bottom:6.0pt;text-align:
     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1">Your
     station of duty will be as decided by the Company. </li><li class="MsoNormal" style="margin-top:6.0pt;margin-bottom:6.0pt;text-align:
     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1">Your
     remuneration is fixed at 25,000 BDT (Twenty-Five Thousand Taka) per Month.</li><li class="MsoNormal" style="margin-top:6.0pt;margin-bottom:6.0pt;text-align:
     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1">You
     must not engage yourself in any work or carryout any other assignment for
     which you have no permission of the management of the company. </li><li class="MsoNormal" style="margin-top:6.0pt;margin-bottom:6.0pt;text-align:
     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1">You
     must not disclose any secret information or any matter prejudicial to the
     interest of the Company.</li><li class="MsoNormal" style="margin-top:6.0pt;margin-bottom:6.0pt;text-align:
     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1">You
     are to abide by all rules and regulations of the Company, prevailing &amp;
     subsequently coming in force from time to time &amp; the service contract
     signed.</li><li class="MsoNormal" style="margin-top:6.0pt;margin-bottom:6.0pt;text-align:
     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1">You
     will not leave the company before you have completed <b style="mso-bidi-font-weight:
     normal">02 (Two) Years of service</b> calculated from the date of your
     joining or a period as may be agreed by you and the company. In breach of
     this provision you shall have to pay compensation to the company.</li><li class="MsoNormal" style="margin-top:6.0pt;margin-bottom:6.0pt;text-align:
     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1">You
     will be on <b style="mso-bidi-font-weight:normal">probation</b> for a
     period of <b style="mso-bidi-font-weight:normal">6 (Six) months</b>, and
     on successful completion of your probation, your services will be
     confirmed for <b style="mso-bidi-font-weight:normal">Permanent Employment.</b></li><li class="MsoNormal" style="margin-top:6.0pt;margin-bottom:6.0pt;  page-break-before: always; text-align:
     justify;text-justify:inter-ideograph;line-height:150%;mso-list:l0 level1 lfo1"><p class="MsoListParagraph" style="text-indent:-.25in;mso-list:l0 level1 lfo1"><b>&nbsp; &nbsp; &nbsp; &nbsp; Festival Bonus:</b></p>

<ol style="margin-top:0in" start="1" type="1"><li class="MsoNormal" style="mso-list:l0 level2 lfo1;tab-stops:list 1.0in">Employees
      who have completed six months of service will be eligible for a festival
      bonus.</li><li class="MsoNormal" style="mso-list:l0 level2 lfo1;tab-stops:list 1.0in">For
      Muslim employees, there will be two Eid bonuses annually, each amounting
      to half of the employee’s monthly salary.</li><li class="MsoNormal" style="mso-list:l0 level2 lfo1;tab-stops:list 1.0in">Employees
      belonging to other religious groups will receive a 100% yearly bonus
      during Durga Puja, equivalent to one full month’s salary.</li></ol></li><li class="MsoNormal" style="mso-list:l0 level1 lfo1;"><b>Late Attendance and Salary Deduction:</b></li><ol style="margin-top:0in" start="1" type="1"><li class="MsoNormal" style="mso-list:l0 level2 lfo1;tab-stops:list 1.0in">The
      company maintains a strict punctuality policy. If an employee is late for
      work three times in a given month, one day's salary will be deducted from
      the total salary for that month.</li></ol><li class="MsoNormal" style="mso-list:l0 level1 lfo1"><b>Financial and Legal
     Responsibility:</b></li><ol style="margin-top:0in" start="1" type="1"><li class="MsoNormal" style="mso-list:l0 level2 lfo1;tab-stops:list 1.0in">RK
      Software (Bangladesh) Limited works with Bangladesh government
      organizations. If any employee is implicated in financial misconduct or
      any criminal activity, the company will not take any liability or
      responsibility for such actions.</li><li class="MsoNormal" style="mso-list:l0 level2 lfo1;tab-stops:list 1.0in">The
      company will fully cooperate with government authorities in investigating
      and resolving any such crimes.</li><li class="MsoNormal" style="mso-list:l0 level2 lfo1;tab-stops:list 1.0in">In
      case of such incidents, the company reserves the right to terminate the
      employee's contract immediately without prior notice.</li></ol><li class="MsoNormal" style="mso-list:l0 level1 lfo1"><b>Resignation Notice:</b></li><ol style="margin-top:0in" start="1" type="1"><li class="MsoNormal" style="mso-list:l0 level2 lfo1;tab-stops:list 1.0in">If
      you wish to resign from your position, you must provide the company with
      a written notice at least two months in advance. Failure to comply with
      this notice period may result in financial penalties or other actions as
      per company policy.</li></ol></ol>

<p class="MsoNormal" style="margin-top:6.0pt;margin-right:0in;margin-bottom:6.0pt;
margin-left:0in;text-align:justify;text-justify:inter-ideograph"><br>
If the above terms &amp; conditions are acceptable, you are advised to report
for duty to the Administration Department immediately. </p>

<p class="MsoNormal"><span style="mso-no-proof:yes">&nbsp;</span></p>

<p class="MsoNormal">&nbsp;</p>

<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">Goutam Saha</p>

<p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">Chairman</p><p class="MsoNormal" style="margin-bottom:0in;margin-bottom:.0001pt">RK Software (Bangladesh) Ltd</p><br>


                                        </textarea>
                                        @error('letter')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Generate</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('customJs')
<script>
  $(function () {
    //Add text editor
    $('#compose-textarea').summernote()
  })
</script>
@endsection
