<?php
	$total = 0;
	$EndofFirstWeekDate = date("Y/m/d", strtotime($FirstWeekofMonthDate.'+'. '6' . 'days'));
	$emp_measures_first_week = DB::table('main_activities')
						->join('employs', 'employs.id', '=', 'main_activities.EmpID')
						->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
		                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
		                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
		                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
		                ->where('main_activities.EmpID', '=', $id)
		                ->where('sub_activities.EmpID', '=', $id)
		                ->whereBetween('daily_accomplishments.Date', array($FirstWeekofMonthDate, $EndofFirstWeekDate))
		                ->whereBetween('measure_variants.MeasureVariantDate', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
		                ->where('MeasureName', '=', $emp_activity->MeasureName)
		                ->orderBy('main_activities.id','asc')
		                ->orderBy('sub_activities.id', 'asc')
		                ->get();
		                //dd($FirstWeekofMonthDate);
?>
@if($emp_measures_first_week != null)
	@foreach($emp_measures_first_week as $emp_measure)
		<?php
				$MonDate = date("Y/m/d", strtotime($emp_measure->Date));
		        $TueDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '1' . 'days'));
		        $WedDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '2' . 'days'));
		        $ThuDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '3' . 'days'));
		        $FriDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '4' . 'days'));
		        $SatDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '5' . 'days'));
		        $SunDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '6' . 'days'));
		        //dd($MonthStartDate);
		?>
		@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
	    	<td>{{ $emp_measure->MondayValue }}</td>
	    	<?php $total = $total + $emp_measure->MondayValue; ?>
	    @endif
	    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
	   		<td>{{ $emp_measure->TuesdayValue }}</td>
	   		<?php $total = $total + $emp_measure->TuesdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
	  		<td>{{ $emp_measure->WednesdayValue }}</td>
	  		<?php $total = $total + $emp_measure->WednesdayValue; ?>
	  	@endif
	  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->ThursdayValue }}</td>
	   		<?php $total = $total + $emp_measure->ThursdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->FridayValue }}</td>
	   		<?php $total = $total + $emp_measure->FridayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SaturdayValue }}</td>
	   		<?php $total = $total + $emp_measure->SaturdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SundayValue }}</td>
	   		<?php $total = $total + $emp_measure->SundayValue; ?>
	   	@endif
	@endforeach
@else
	<?php
			$MonDate = date("Y/m/d", strtotime($FirstWeekofMonthDate));
	        $TueDate = date("Y/m/d", strtotime($FirstWeekofMonthDate .'+'. '1' . 'days'));
	        $WedDate = date("Y/m/d", strtotime($FirstWeekofMonthDate .'+'. '2' . 'days'));
	        $ThuDate = date("Y/m/d", strtotime($FirstWeekofMonthDate .'+'. '3' . 'days'));
	        $FriDate = date("Y/m/d", strtotime($FirstWeekofMonthDate .'+'. '4' . 'days'));
	        $SatDate = date("Y/m/d", strtotime($FirstWeekofMonthDate .'+'. '5' . 'days'));
	        $SunDate = date("Y/m/d", strtotime($FirstWeekofMonthDate .'+'. '6' . 'days'));
	        //dd($MonthStartDate);
	?>
	@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
    	<td></td>
    @endif
    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
   		<td></td>
   	@endif
   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
  		<td></td>
  	@endif
  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
@endif 

{{--END OF QUERING OF FIRST WEEK--}}


<?php
	$SecondWeekofMonthDate = date("Y/m/d", strtotime($FirstWeekofMonthDate.'+'. '7' . 'days'));
	$EndofSecondWeekDate = date("Y/m/d", strtotime($FirstWeekofMonthDate.'+'. '13' . 'days'));
	$emp_measures_second_week = DB::table('main_activities')
						->join('employs', 'employs.id', '=', 'main_activities.EmpID')
						->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
		                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
		                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
		                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
		                ->where('main_activities.EmpID', '=', $id)
		                ->where('sub_activities.EmpID', '=', $id)
		                ->whereBetween('daily_accomplishments.Date', array($SecondWeekofMonthDate, $EndofSecondWeekDate))
		                ->whereBetween('measure_variants.MeasureVariantDate', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
		                ->where('MeasureName', '=', $emp_activity->MeasureName)
		                ->orderBy('main_activities.id','asc')
		                ->orderBy('sub_activities.id', 'asc')
		                ->get();
		                //dd($EndofSecondWeekDate);
?>

@if($emp_measures_second_week != null)
	@foreach($emp_measures_second_week as $emp_measure)
		<?php
				$MonDate = date("Y/m/d", strtotime($emp_measure->Date));
		        $TueDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '1' . 'days'));
		        $WedDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '2' . 'days'));
		        $ThuDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '3' . 'days'));
		        $FriDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '4' . 'days'));
		        $SatDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '5' . 'days'));
		        $SunDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '6' . 'days'));
		        //dd($MonthStartDate);
		?>
		@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
	    	<td>{{ $emp_measure->MondayValue }}</td>
	    	<?php $total = $total + $emp_measure->MondayValue; ?>
	    @endif
	    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
	   		<td>{{ $emp_measure->TuesdayValue }}</td>
	   		<?php $total = $total + $emp_measure->TuesdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
	  		<td>{{ $emp_measure->WednesdayValue }}</td>
	  		<?php $total = $total + $emp_measure->WednesdayValue; ?>
	  	@endif
	  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->ThursdayValue }}</td>
	   		<?php $total = $total + $emp_measure->ThursdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->FridayValue }}</td>
	   		<?php $total = $total + $emp_measure->FridayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SaturdayValue }}</td>
	   		<?php $total = $total + $emp_measure->SaturdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SundayValue }}</td>
	   		<?php $total = $total + $emp_measure->SundayValue; ?>
	   	@endif
	@endforeach
@else
	<?php
			$MonDate = date("Y/m/d", strtotime($SecondWeekofMonthDate));
	        $TueDate = date("Y/m/d", strtotime($SecondWeekofMonthDate .'+'. '1' . 'days'));
	        $WedDate = date("Y/m/d", strtotime($SecondWeekofMonthDate .'+'. '2' . 'days'));
	        $ThuDate = date("Y/m/d", strtotime($SecondWeekofMonthDate .'+'. '3' . 'days'));
	        $FriDate = date("Y/m/d", strtotime($SecondWeekofMonthDate .'+'. '4' . 'days'));
	        $SatDate = date("Y/m/d", strtotime($SecondWeekofMonthDate .'+'. '5' . 'days'));
	        $SunDate = date("Y/m/d", strtotime($SecondWeekofMonthDate .'+'. '6' . 'days'));
	        //dd($SunDate);
	?>
	@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
    	<td></td>
    @endif
    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
   		<td></td>
   	@endif
   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
  		<td></td>
  	@endif
  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
@endif 

{{--END OF QUERING OF SECOND WEEK--}}

<?php
	$ThirdWeekofMonthDate = date("Y/m/d", strtotime($SecondWeekofMonthDate.'+'. '7' . 'days'));
	$EndofThirdWeekDate = date("Y/m/d", strtotime($SecondWeekofMonthDate.'+'. '13' . 'days'));
	$emp_measures_third_week = DB::table('main_activities')
						->join('employs', 'employs.id', '=', 'main_activities.EmpID')
						->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
		                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
		                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
		                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
		                ->where('main_activities.EmpID', '=', $id)
		                ->where('sub_activities.EmpID', '=', $id)
		                ->whereBetween('daily_accomplishments.Date', array($ThirdWeekofMonthDate, $EndofThirdWeekDate))
		                ->whereBetween('measure_variants.MeasureVariantDate', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
		                ->where('MeasureName', '=', $emp_activity->MeasureName)
		                ->orderBy('main_activities.id','asc')
		                ->orderBy('sub_activities.id', 'asc')
		                ->get();
		                //dd($EndofThirdWeekDate);
?>


@if($emp_measures_third_week != null)
	@foreach($emp_measures_third_week as $emp_measure)
		<?php
				$MonDate = date("Y/m/d", strtotime($emp_measure->Date));
		        $TueDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '1' . 'days'));
		        $WedDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '2' . 'days'));
		        $ThuDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '3' . 'days'));
		        $FriDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '4' . 'days'));
		        $SatDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '5' . 'days'));
		        $SunDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '6' . 'days'));
		        //dd($ThirdWeekofMonthDate);
		?>
		@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
	    	<td>{{ $emp_measure->MondayValue }}</td>
	    	<?php $total = $total + $emp_measure->MondayValue; ?>
	    @endif
	    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
	   		<td>{{ $emp_measure->TuesdayValue }}</td>
	   		<?php $total = $total + $emp_measure->TuesdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
	  		<td>{{ $emp_measure->WednesdayValue }}</td>
	  		<?php $total = $total + $emp_measure->WednesdayValue; ?>
	  	@endif
	  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->ThursdayValue }}</td>
	   		<?php $total = $total + $emp_measure->ThursdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->FridayValue }}</td>
	   		<?php $total = $total + $emp_measure->FridayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SaturdayValue }}</td>
	   		<?php $total = $total + $emp_measure->SaturdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SundayValue }}</td>
	   		<?php $total = $total + $emp_measure->SundayValue; ?>
	   	@endif
	@endforeach
@else
	<?php
			$MonDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate));
	        $TueDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate .'+'. '1' . 'days'));
	        $WedDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate .'+'. '2' . 'days'));
	        $ThuDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate .'+'. '3' . 'days'));
	        $FriDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate .'+'. '4' . 'days'));
	        $SatDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate .'+'. '5' . 'days'));
	        $SunDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate .'+'. '6' . 'days'));
	        //dd($SecondWeekofMonthDate);
	?>
	@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
    	<td></td>
    @endif
    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
   		<td></td>
   	@endif
   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
  		<td></td>
  	@endif
  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
@endif 

{{--END OF QUERING OF THIRD WEEK--}}


<?php
	$FourthWeekofMonthDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate .'+'. '7' . 'days'));
	$EndofFourthWeekDate = date("Y/m/d", strtotime($ThirdWeekofMonthDate .'+'. '13' . 'days'));
	$emp_measures_fourth_week = DB::table('main_activities')
						->join('employs', 'employs.id', '=', 'main_activities.EmpID')
						->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
		                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
		                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
		                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
		                ->where('main_activities.EmpID', '=', $id)
		                ->where('sub_activities.EmpID', '=', $id)
		                ->whereBetween('daily_accomplishments.Date', array($FourthWeekofMonthDate, $EndofFourthWeekDate))
		                ->whereBetween('measure_variants.MeasureVariantDate', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
		                ->where('MeasureName', '=', $emp_activity->MeasureName)
		                ->orderBy('main_activities.id','asc')
		                ->orderBy('sub_activities.id', 'asc')
		                ->get();
		                //dd($FourthWeekofMonthDate);
?>


@if($emp_measures_fourth_week != null)
	@foreach($emp_measures_fourth_week as $emp_measure)
		<?php
				$MonDate = date("Y/m/d", strtotime($emp_measure->Date));
		        $TueDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '1' . 'days'));
		        $WedDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '2' . 'days'));
		        $ThuDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '3' . 'days'));
		        $FriDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '4' . 'days'));
		        $SatDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '5' . 'days'));
		        $SunDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '6' . 'days'));
		        //dd($SunDate);
		?>
		@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
	    	<td>{{ $emp_measure->MondayValue }}</td>
	    	<?php $total = $total + $emp_measure->MondayValue; ?>
	    @endif
	    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
	   		<td>{{ $emp_measure->TuesdayValue }}</td>
	   		<?php $total = $total + $emp_measure->TuesdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
	  		<td>{{ $emp_measure->WednesdayValue }}</td>
	  		<?php $total = $total + $emp_measure->WednesdayValue; ?>
	  	@endif
	  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->ThursdayValue }}</td>
	   		<?php $total = $total + $emp_measure->ThursdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->FridayValue }}</td>
	   		<?php $total = $total + $emp_measure->FridayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SaturdayValue }}</td>
	   		<?php $total = $total + $emp_measure->SaturdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SundayValue }}</td>
	   		<?php $total = $total + $emp_measure->SundayValue; ?>
	   	@endif
	@endforeach
@else
	<?php
			$MonDate = date("Y/m/d", strtotime($FourthWeekofMonthDate));
	        $TueDate = date("Y/m/d", strtotime($FourthWeekofMonthDate .'+'. '1' . 'days'));
	        $WedDate = date("Y/m/d", strtotime($FourthWeekofMonthDate .'+'. '2' . 'days'));
	        $ThuDate = date("Y/m/d", strtotime($FourthWeekofMonthDate .'+'. '3' . 'days'));
	        $FriDate = date("Y/m/d", strtotime($FourthWeekofMonthDate .'+'. '4' . 'days'));
	        $SatDate = date("Y/m/d", strtotime($FourthWeekofMonthDate .'+'. '5' . 'days'));
	        $SunDate = date("Y/m/d", strtotime($FourthWeekofMonthDate .'+'. '6' . 'days'));
	        //dd($MonthStartDate);
	?>
	@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
    	<td></td>
    @endif
    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
   		<td></td>
   	@endif
   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
  		<td></td>
  	@endif
  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
@endif 

{{--END OF QUERING OF FOURTH WEEK--}}

<?php
	$FifthWeekofMonthDate = date("Y/m/d", strtotime($FourthWeekofMonthDate .'+'. '7' . 'days'));
	$EndofFifthWeekDate = date("Y/m/d", strtotime($FourthWeekofMonthDate .'+'. '13' . 'days'));
	$emp_measures_fifth_week = DB::table('main_activities')
						->join('employs', 'employs.id', '=', 'main_activities.EmpID')
						->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
		                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
		                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
		                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
		                ->where('main_activities.EmpID', '=', $id)
		                ->where('sub_activities.EmpID', '=', $id)
		                ->whereBetween('daily_accomplishments.Date', array($FifthWeekofMonthDate, $EndofFifthWeekDate))
		                ->whereBetween('measure_variants.MeasureVariantDate', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
		                ->where('MeasureName', '=', $emp_activity->MeasureName)
		                ->orderBy('main_activities.id','asc')
		                ->orderBy('sub_activities.id', 'asc')
		                ->get();
		                //dd($FifthWeekofMonthDate);
?>


@if($emp_measures_fifth_week != null)
	@foreach($emp_measures_fifth_week as $emp_measure)
		<?php
				$MonDate = date("Y/m/d", strtotime($emp_measure->Date));
		        $TueDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '1' . 'days'));
		        $WedDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '2' . 'days'));
		        $ThuDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '3' . 'days'));
		        $FriDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '4' . 'days'));
		        $SatDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '5' . 'days'));
		        $SunDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '6' . 'days'));
		        //dd($SunDate);
		?>
		@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
	    	<td>{{ $emp_measure->MondayValue }}</td>
	    	<?php $total = $total + $emp_measure->MondayValue; ?>
	    @endif
	    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
	   		<td>{{ $emp_measure->TuesdayValue }}</td>
	   		<?php $total = $total + $emp_measure->TuesdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
	  		<td>{{ $emp_measure->WednesdayValue }}</td>
	  		<?php $total = $total + $emp_measure->WednesdayValue; ?>
	  	@endif
	  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->ThursdayValue }}</td>
	   		<?php $total = $total + $emp_measure->ThursdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->FridayValue }}</td>
	   		<?php $total = $total + $emp_measure->FridayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SaturdayValue }}</td>
	   		<?php $total = $total + $emp_measure->SaturdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SundayValue }}</td>
	   		<?php $total = $total + $emp_measure->SundayValue; ?>
	   	@endif
	@endforeach
@else
	<?php
			$MonDate = date("Y/m/d", strtotime($FifthWeekofMonthDate));
	        $TueDate = date("Y/m/d", strtotime($FifthWeekofMonthDate.'+'. '1' . 'days'));
	        $WedDate = date("Y/m/d", strtotime($FifthWeekofMonthDate.'+'. '2' . 'days'));
	        $ThuDate = date("Y/m/d", strtotime($FifthWeekofMonthDate.'+'. '3' . 'days'));
	        $FriDate = date("Y/m/d", strtotime($FifthWeekofMonthDate.'+'. '4' . 'days'));
	        $SatDate = date("Y/m/d", strtotime($FifthWeekofMonthDate.'+'. '5' . 'days'));
	        $SunDate = date("Y/m/d", strtotime($FifthWeekofMonthDate.'+'. '6' . 'days'));
	        //dd($SunDate);
	?>
	@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
    	<td></td>
    @endif
    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
   		<td></td>
   	@endif
   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
  		<td></td>
  	@endif
  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
@endif 

{{--END OF QUERING OF FIFTH WEEK--}}

<?php
	$SixthWeekofMonthDate = date("Y/m/d", strtotime($FifthWeekofMonthDate .'+'. '7' . 'days'));
	$EndofSixthWeekDate = date("Y/m/d", strtotime($FifthWeekofMonthDate .'+'. '13' . 'days'));
	$emp_measures_sixth_week = DB::table('main_activities')
						->join('employs', 'employs.id', '=', 'main_activities.EmpID')
						->join('sub_activities', 'main_activities.id', '=', 'sub_activities.MainActivityID')
		                ->join('measures', 'sub_activities.id', '=', 'measures.SubActivityID')
		                ->join('measure_variants', 'measures.id', '=', 'measure_variants.MeasureID')
		                ->join('daily_accomplishments', 'measure_variants.id', '=', 'daily_accomplishments.MeasureVariantID')
		                ->where('main_activities.EmpID', '=', $id)
		                ->where('sub_activities.EmpID', '=', $id)
		                ->whereBetween('daily_accomplishments.Date', array($SixthWeekofMonthDate, $EndofSixthWeekDate))
		                ->whereBetween('measure_variants.MeasureVariantDate', array($FirstWeekofMonthDate, $LastWeekofMonthDate))
		                ->where('MeasureName', '=', $emp_activity->MeasureName)
		                ->orderBy('main_activities.id','asc')
		                ->orderBy('sub_activities.id', 'asc')
		                ->get();
		                //dd($FifthWeekofMonthDate);
?>


@if($emp_measures_sixth_week != null)
	@foreach($emp_measures_sixth_week as $emp_measure)
		<?php
				$MonDate = date("Y/m/d", strtotime($emp_measure->Date));
		        $TueDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '1' . 'days'));
		        $WedDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '2' . 'days'));
		        $ThuDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '3' . 'days'));
		        $FriDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '4' . 'days'));
		        $SatDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '5' . 'days'));
		        $SunDate = date("Y/m/d", strtotime($emp_measure->Date.'+'. '6' . 'days'));
		        //dd($SunDate);
		?>
		@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
	    	<td>{{ $emp_measure->MondayValue }}</td>
	    	<?php $total = $total + $emp_measure->MondayValue; ?>
	    @endif
	    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
	   		<td>{{ $emp_measure->TuesdayValue }}</td>
	   		<?php $total = $total + $emp_measure->TuesdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
	  		<td>{{ $emp_measure->WednesdayValue }}</td>
	  		<?php $total = $total + $emp_measure->WednesdayValue; ?>
	  	@endif
	  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->ThursdayValue }}</td>
	   		<?php $total = $total + $emp_measure->ThursdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->FridayValue }}</td>
	   		<?php $total = $total + $emp_measure->FridayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SaturdayValue }}</td>
	   		<?php $total = $total + $emp_measure->SaturdayValue; ?>
	   	@endif
	   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
	   		<td>{{ $emp_measure->SundayValue }}</td>
	   		<?php $total = $total + $emp_measure->SundayValue; ?>
	   	@endif
	@endforeach
@else
	<?php
			$MonDate = date("Y/m/d", strtotime($SixthWeekofMonthDate));
	        $TueDate = date("Y/m/d", strtotime($SixthWeekofMonthDate.'+'. '1' . 'days'));
	        $WedDate = date("Y/m/d", strtotime($SixthWeekofMonthDate.'+'. '2' . 'days'));
	        $ThuDate = date("Y/m/d", strtotime($SixthWeekofMonthDate.'+'. '3' . 'days'));
	        $FriDate = date("Y/m/d", strtotime($SixthWeekofMonthDate.'+'. '4' . 'days'));
	        $SatDate = date("Y/m/d", strtotime($SixthWeekofMonthDate.'+'. '5' . 'days'));
	        $SunDate = date("Y/m/d", strtotime($SixthWeekofMonthDate.'+'. '6' . 'days'));
	        //dd($SunDate);
	?>
	@if(date("m", strtotime($MonDate)) == date("m", strtotime($MonthStartDate)))
    	<td></td>
    @endif
    @if(date("m", strtotime($TueDate)) == date("m", strtotime($MonthStartDate)))	
   		<td></td>
   	@endif
   	@if(date("m", strtotime($WedDate)) == date("m", strtotime($MonthStartDate)))
  		<td></td>
  	@endif
  	@if(date("m", strtotime($ThuDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($FriDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SatDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
   	@if(date("m", strtotime($SunDate)) == date("m", strtotime($MonthStartDate)))
   		<td></td>
   	@endif
@endif 

{{--END OF QUERING OF SIXTH WEEK--}}

<td>{{ $total }}</td>
<td></td>
<td></td>