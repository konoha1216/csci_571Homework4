import { Component, OnInit } from '@angular/core';
import {SearchServiceService} from '../../service/search-service.service'

@Component({
  selector: 'app-current',
  templateUrl: './current.component.html',
  styleUrls: ['./current.component.css']
})
export class CurrentComponent implements OnInit {

  public weatherData:any;
  public sealData:any;
  public sealUrl:string;

  public currentCity:string;
  public currentZone:string;
  public currentTem:string;
  public currentSummary:string;
  public currentHumidity:string;

  public currentPressure:string;

  public currentWind:string;

  public currentVisibility:string;

  public currentCloud:string;

  public currentOzone:string;



  constructor(public sService:SearchServiceService) { 

    this.sService.weatherJson.subscribe(data =>{
      console.log('currentCity',this.sService.city);
      this.currentCity = this.sService.city;
      this.weatherData = data;
      console.log(data);
      this.currentZone = this.weatherData['timezone'];
      this.currentTem = this.weatherData['currently']['temperature'];
      this.currentSummary = this.weatherData['currently']['summary'];
      this.currentHumidity = this.weatherData['currently']['humidity'];
      
      this.currentPressure = this.weatherData['currently']['pressure'];
      
      this.currentWind = this.weatherData['currently']['windSpeed'];
      
      this.currentVisibility = this.weatherData['currently']['visibility'];
      
      this.currentCloud = this.weatherData['currently']['cloudCover'];
      
      this.currentOzone = this.weatherData['currently']['ozone'];

      document.getElementById("progressBar").style.display="none";

    })
    this.sService.sealJson.subscribe(data =>{
      this.sealData = data;
      console.log(data);
      if(data['items'][0]){
        this.sealUrl = data['items'][0]['link'];
      }
    })
  }


  ngOnInit() {
  }

}
