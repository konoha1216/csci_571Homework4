import { Component, OnInit } from '@angular/core';
import {SearchServiceService} from '../../service/search-service.service'
import { stringify } from 'querystring';



@Component({
  selector: 'app-weekly',
  templateUrl: './weekly.component.html',
  styleUrls: ['./weekly.component.css']
})
export class WeeklyComponent implements OnInit {

  public timezone:string;
  public latitude:string;
  public longitude:string;
  public timestamp:string[] = [];
  public dates:string[] = [];
  public temperatureLow:string[] = [];
  public temperatureHigh:string[] = [];
  public temperature:any = [];

  public modeCity:string
  public dateData:any

  constructor(public sService:SearchServiceService) {

    this.sService.weatherJson.subscribe(data => {



      this.modeCity = this.sService.city;
      this.latitude = data['latitude'];
      this.longitude = data['longitude'];
      this.timezone = data['timezone'];
      for(var i=0; i<7; i++){
        // this.temperature.push([Math.round(data['daily']['data'][i]['temperatureLow']),Math.round(data['daily']['data'][i]['temperatureHigh'])]);
        // this.temperatureLow.push(data['daily']['data'][i]['temperatureLow']);
        // this.temperatureHigh.push(data['daily']['data'][i]['temperatureHigh']);
        // this.timestamp.push(data['daily']['data'][i]['time']);
        // this.dates.push(this.timeStamp2date(data['daily']['data'][i]['time'],this.timezone));

        this.temperature[i]=([Math.round(data['daily']['data'][i]['temperatureLow']),Math.round(data['daily']['data'][i]['temperatureHigh'])]);
        this.temperatureLow[i]=(data['daily']['data'][i]['temperatureLow']);
        this.temperatureHigh[i]=(data['daily']['data'][i]['temperatureHigh']);
        this.timestamp[i]=(data['daily']['data'][i]['time']);
        this.dates[i]=(this.timeStamp2date(data['daily']['data'][i]['time'],this.timezone));
      }
      console.log('temperature array length', this.temperature.length);
      console.log(this.temperature[0]);
      console.log('timestamp length:', this.timestamp.length);
      this.sService.dateSearch(this.latitude, this.longitude, this.timestamp);
    })

    
    this.sService.dateJson.subscribe(data => {
      this.dateData = data;
      console.log('date data:');
      console.log(data);
    })

   }

  timeStamp2date(mytimeStamp:string,timezone:string){
    console.log('timezone transfer begins here:')
    var myTS = Number(mytimeStamp)*1000;
    var date:any = new Date(myTS);
    console.log(timezone);
    date = date.toLocaleString('en-US',{"timeZone":timezone});
    var newDate = new Date(date);
    var year = newDate.getFullYear();
    var month = newDate.getMonth()+1 < 10 ? '0'+(newDate.getMonth()+1) : newDate.getMonth()+1;
    var day = newDate.getDate();
    console.log(year+'/'+month+'/'+day)
    return year+'/'+month+'/'+day;
}

  public weeklyOptions = {
    responsive: true,
    scaleShowVerticalLines: false,
    scaleShowHorizontalLines: false,
    
    scales: {yAxes: [{gridLines:{display:true, drawBorder:true, drawOnChartArea:false},  scaleLabel: {display: true,labelString: 'Days'}}],xAxes: [{gridLines:{display:true, drawBorder:true, drawOnChartArea:false}, scaleLabel: {display: true,labelString: 'Temperature in Fahrenheit'}}]},
    title:{display:true, text:'Weekly Weather', fontStyle:'bold', fontSize: 24, fontColor:'#000'}
  };
  public weeklyLabels = this.dates;
  public weeklyType = 'horizontalBar';
  public weeklyLegend = {display:true};
  public weeklyData = [
    {data: this.temperature, label: 'Day wise temperature range', backgroundColor:'rgb(141,200,237)', borderColor:'rgb(141,200,237)',hoverBackgroundColor:'rgba(141,200,237,0.5)'}
  ];

  public display = 'none';
  openModal(){
    this.display='block';
  }
  onCloseHandled(){
    this.display='none';
  }

  public modeDate:any;
  public modeTemperature:any;
  public modeSummary:any;
  public modeIcon:any;
  public modePrecipitation:any;
  public modeRain:any;
  public modeWind:any;
  public modeHumidity:any;
  public modeVisibility:any;
  
  whichIcon(icon){
    if(icon=="clear-day" || icon=="clear-night"){
      return 'https://cdn3.iconfinder.com/data/icons/weather-344/142/sun-512.png'
    }else if(icon=="rain"){
      return 'https://cdn3.iconfinder.com/data/icons/weather-344/142/rain-512.png'
    }else if(icon=="snow"){
      return 'https://cdn3.iconfinder.com/data/icons/weather-344/142/snow-512.png'
    }else if(icon=="sleet"){
      return 'https://cdn3.iconfinder.com/data/icons/weather-344/142/lightning-512.png'
    }else if(icon=="wind"){
      return 'https://cdn4.iconfinder.com/data/icons/the-weather-is-nice-today/64/weather_10-512.png'
    }else if(icon=="fog"){
      return 'https://cdn3.iconfinder.com/data/icons/weather-344/142/cloudy-512.png'
    }else if(icon=="cloudy"){
      return 'https://cdn3.iconfinder.com/data/icons/weather-344/142/cloud-512.png'
    }else if(icon=="partly-cloudy-day" || icon=="partly-cloudy-night"){
      return 'https://cdn3.iconfinder.com/data/icons/weather-344/142/sunny-512.png'
    }
  }

  onChartClick(event){
    console.log(event);
    if(event['active'][0]['_index']>=0){
      console.log(event['active'][0]['_index']);
      var whichDay = event['active'][0]['_index'];

      this.modeDate = this.dates[whichDay];
      this.modeTemperature = Math.round(Number(this.dateData[whichDay]['currently']['temperature'])).toString();
      this.modeSummary = this.dateData[whichDay]['currently']['summary'];
      this.modeIcon = this.whichIcon(this.dateData[whichDay]['currently']['icon'])
      this.modePrecipitation = this.dateData[whichDay]['currently']['precipIntensity'].toFixed(2)==0?'0':this.dateData[whichDay]['currently']['precipIntensity'].toFixed(2)==0;
      this.modeRain = (this.dateData[whichDay]['currently']['precipProbability']*100).toString();
      this.modeWind = (this.dateData[whichDay]['currently']['windSpeed'].toFixed(2)).toString();
      this.modeHumidity = (this.dateData[whichDay]['currently']['humidity']*100).toString();
      this.modeVisibility = this.dateData[whichDay]['currently']['visibility'];

      this.openModal();
    }
  }



  ngOnInit() {
  }

}
