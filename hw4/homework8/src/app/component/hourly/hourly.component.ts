import { Component, OnInit } from '@angular/core';
import {SearchServiceService} from '../../service/search-service.service'

@Component({
  selector: 'app-hourly',
  templateUrl: './hourly.component.html',
  styleUrls: ['./hourly.component.css']
})
export class HourlyComponent implements OnInit {

  public hourlyItems = [{'name':'Temperature'}, {'name':'Pressure'}, {'name':'Humidity'}, {'name':'Ozone'}, {'name':'Visibility'}, {'name':'Wind Speed'}];

  public temperature:any = [];
  public pressure:any = [];
  public humidity:any = [];
  public ozone:any = [];
  public visibility:any = [];
  public windSpeed:any = [];
  public hourly:any = ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];

  constructor(public sService:SearchServiceService) {
    this.sService.weatherJson.subscribe(data => {
      // this.temperature=[];
      // this.pressure=[];
      // this.humidity=[];
      // this.ozone=[];
      // this.visibility=[];
      // this.windSpeed=[];

      for(var i=0; i<24; i++){
        // this.temperature.push(data['hourly']['data'][i]['temperature']);
        // this.pressure.push(data['hourly']['data'][i]['pressure']);
        // this.humidity.push(data['hourly']['data'][i]['humidity']);
        // this.ozone.push(data['hourly']['data'][i]['ozone']);

        this.temperature[i]=(data['hourly']['data'][i]['temperature']);
        this.pressure[i]=(data['hourly']['data'][i]['pressure']);
        this.humidity[i]=(data['hourly']['data'][i]['humidity']);
        this.ozone[i]=(data['hourly']['data'][i]['ozone']);

        if(data['hourly']['data'][i]['visibility']>10){
          this.visibility[i]=(10);
        }else{
          this.visibility[i]=(data['hourly']['data'][i]['visibility']);
        }
        // this.windSpeed.push(data['hourly']['data'][i]['windSpeed']);
        this.windSpeed[i]=(data['hourly']['data'][i]['windSpeed']);
      }
    })
   }

  // temperature
  public temperatureOptions = {
    scaleShowVerticalLines: false,
    responsive: true,
    // onHover: function(){this.backgroundColor='rgb(141,200,237)'},
    scales: {yAxes: [{scaleLabel: {display: true,labelString: 'Fahrenheit'}}],xAxes: [{scaleLabel: {display: true,labelString: 'Time Difference from current Hour'}}]}
  };
  public temperatureLabels = this.hourly;
  public temperatureType = 'bar';
  public temperatureLegend = true;
  public temperatureData = [{data: this.temperature, label: 'temperature', backgroundColor:'rgb(141,200,237)', borderColor:'rgb(141,200,237)',hoverBackgroundColor:'rgba(141,200,237,0.5)'}];
  // pressure
  public pressureOptions = {
    scaleShowVerticalLines: false,
    responsive: true,
    scales: {yAxes: [{scaleLabel: {display: true,labelString: 'Millibars'}}],xAxes: [{scaleLabel: {display: true,labelString: 'Time Difference from current Hour'}}]}
  };
  public pressureLabels = this.hourly;
  public pressureType = 'bar';
  public pressureLegend = true;
  public pressureData = [{data: this.pressure, label: 'pressure', backgroundColor:'rgb(141,200,237)', borderColor:'rgb(141,200,237)',hoverBackgroundColor:'rgba(141,200,237,0.5)'}];

  // humidity
  public humidityOptions = {
    scaleShowVerticalLines: false,
    responsive: true,
    scales: {yAxes: [{scaleLabel: {display: true,labelString: '% Humidity'}}],xAxes: [{scaleLabel: {display: true,labelString: 'Time Difference from current Hour'}}]}
  };
  public humidityLabels = this.hourly;
  public humidityType = 'bar';
  public humidityLegend = true;
  public humidityData = [{data: this.humidity, label: 'humidity', backgroundColor:'rgb(141,200,237)', borderColor:'rgb(141,200,237)',hoverBackgroundColor:'rgba(141,200,237,0.5)'}];

  // ozone
  public ozoneOptions = {
    scaleShowVerticalLines: false,
    responsive: true,
    scales: {yAxes: [{scaleLabel: {display: true,labelString: 'Dobson Units'}}],xAxes: [{scaleLabel: {display: true,labelString: 'Time Difference from current Hour'}}]}
  };
  public ozoneLabels = this.hourly;
  public ozoneType = 'bar';
  public ozoneLegend = true;
  public ozoneData = [{data: this.ozone, label: 'ozone', backgroundColor:'rgb(141,200,237)', borderColor:'rgb(141,200,237)',hoverBackgroundColor:'rgba(141,200,237,0.5)'}];

  // visibility
  public visibilityOptions = {
    scaleShowVerticalLines: false,
    responsive: true,
    scales: {yAxes: [{scaleLabel: {display: true,labelString: 'Miles (Maximum 10)'}}],xAxes: [{scaleLabel: {display: true,labelString: 'Time Difference from current Hour'}}]}
  };
  public visibilityLabels = this.hourly;
  public visibilityType = 'bar';
  public visibilityLegend = true;
  public visibilityData = [{data: this.visibility, label: 'visibility', backgroundColor:'rgb(141,200,237)', borderColor:'rgb(141,200,237)',hoverBackgroundColor:'rgba(141,200,237,0.5)'}];

  // humidity
  public windOptions = {
    scaleShowVerticalLines: false,
    responsive: true,
    scales: {yAxes: [{scaleLabel: {display: true,labelString: 'Miles per Hour'}}],xAxes: [{scaleLabel: {display: true,labelString: 'Time Difference from current Hour'}}]}
  };
  public windLabels = this.hourly;
  public windType = 'bar';
  public windLegend = true;
  public windData = [{data: this.windSpeed, label: 'windSpeed', backgroundColor:'rgb(141,200,237)', borderColor:'rgb(141,200,237)',hoverBackgroundColor:'rgba(141,200,237,0.5)'}];

  ngOnInit() {
  }

  onChange(index){
    document.getElementById('hourlyTemperature').style.display='none';
    document.getElementById('hourlyPressure').style.display='none';
    document.getElementById('hourlyHumidity').style.display='none';
    document.getElementById('hourlyOzone').style.display='none';
    document.getElementById('hourlyVisibility').style.display='none';
    document.getElementById('hourlyWind').style.display='none';

    console.log(index);

    if(index==0){
      document.getElementById('hourlyTemperature').style.display='block';
    }
    else if(index==1){
      document.getElementById('hourlyPressure').style.display='block';
    }
    else if(index==2){
      document.getElementById('hourlyHumidity').style.display='block';
    }
    else if(index==3){
      document.getElementById('hourlyOzone').style.display='block';
    }
    else if(index==4){
      document.getElementById('hourlyVisibility').style.display='block';
    }
    else if(index==5){
      document.getElementById('hourlyWind').style.display='block';
    }

  }
}
