import { Component, OnInit } from '@angular/core';
import {SearchServiceService} from '../../service/search-service.service'


@Component({
  selector: 'app-navs',
  templateUrl: './navs.component.html',
  styleUrls: ['./navs.component.css']
})
export class NavsComponent implements OnInit {

  public twitterCity:any;
  public twitterState:any;
  public twitterTemperature:any;
  public twitterSummary:any;
  public twitterContent:any;
  public twitterUrl:any;
  public showResult = false;
  public noRecord = true;
  public reLat:any;
  public reLng:any;
  public geodata:any;

  public itemData:object={};
  public favoriteData:any;

  public star="star_border";
  public cartColor='black';

  public testRecord=false;

  constructor(public sService:SearchServiceService) {

    this.sService.weatherJson.subscribe(data => {

    this.reLat = sService.lat;
    this.reLng = sService.lng;
    this.twitterCity = this.sService.city;
    this.twitterState = this.sService.state;

    this.itemData['city'] = this.twitterCity;
    this.itemData['state'] = this.twitterState;
    this.itemData['lat'] = this.reLat;
    this.itemData['Lng'] = this.reLng;

    this.twitterTemperature=data['currently']['temperature'];
    this.twitterSummary=data['currently']['summary'];

    this.twitterContent = encodeURIComponent('The current temperature at '+this.twitterCity+' is '+this.twitterTemperature+ '°F'+'. The weather conditions are '+this.twitterSummary+'.'+'#CSCI571WeatherSearch');
    this.twitterUrl = 'https://twitter.com/intent/tweet?text='+this.twitterContent;
    this.noRecord = false;
    
    this.sService.sealSearch();
    })

    this.sService.sealJson.subscribe(data=>{
      this.itemData['seal'] = data['items'][0]['link'];
    }
    )

    this.sService.getAllFavorite();
    this.sService.favoriteList.subscribe(data=>{
      this.favoriteData = data;
      console.log("!!!!!!!!!itemData!!!!!!!!!!",this.itemData['city']);
      console.log("!!!!!!!!!favoriteData!!!!!!!!",this.favoriteData);
      console.log("!!!!!!!!!favoriteData!!!!!!!!!!",JSON.parse(this.favoriteData[0])['city']);
      if(this.itemData){
        for(var j=0; j<this.favoriteData.length; j++){
          // console.log("!!!!!!!!!favoriteData!!!!!!!!!!",this.favoriteData[j]['city']);
          if(this.itemData['city'] == JSON.parse(this.favoriteData[j])['city']){
            console.log('item data and a favorite data is the same!!!!!!!!!!!!!')
            this.star = "grade";
            this.cartColor = "orange";
            break;
          }
        }
        this.star="star_border";
        this.cartColor = "black";

      }
    })
    
    this.sService.resultJson.subscribe(data =>{
      this.showResult = true;
      this.geodata = data['results'];
      this.sService.weatherSearch(this.geodata,1,'','');
      this.sService.sealSearch();

      // console.log('???????????????????',this.geodata);
      if(this.geodata.length==0){
        // console.log("now the test record is true!!!!!!!!!");
        this.testRecord=true;
      }
      
    })

    // this.sService.weatherSearch('',0,this.reLat, this.reLng);

   }

  ngOnInit() {
  }

  setFavorite(){
    if(this.star == "star_border"){
      this.sService.addFavorite(this.itemData);
      this.star = "grade";
      this.cartColor = "orange";
    }else{
      this.sService.removeFavorite1(this.itemData['city']);
      this.star = "star_border";
      this.cartColor = "black";
    }
  }

  showCurrent(){
    var tabs = document.getElementsByClassName("nav-link")
    for(var i=0; i<tabs.length; i++){
      tabs[i].className="nav-link";
    }
    var Cur = document.getElementById('showCurrent');
    Cur.className="nav-link active";
    this.sService.sealSearch();
    this.sService.weatherSearch('',0,this.reLat, this.reLng);
    
    // document.getElementById('appCurrent').style.display='block';
    // document.getElementById('appHourly').style.display='none';
    // document.getElementById('appWeekly').style.display='none';
  }
  showHourly(){
    var tabs = document.getElementsByClassName("nav-link")
    for(var i=0; i<tabs.length; i++){
      tabs[i].className="nav-link";
    }
    var Cur = document.getElementById('showHourly');
    Cur.className="nav-link active";
    this.sService.weatherSearch('',0,this.reLat, this.reLng);

    // document.getElementById('appCurrent').style.display='none';
    // document.getElementById('appHourly').style.display='block';
    // document.getElementById('appWeekly').style.display='none';
  }
  showWeekly(){
    var tabs = document.getElementsByClassName("nav-link")
    for(var i=0; i<tabs.length; i++){
      tabs[i].className="nav-link";
    }
    var Cur = document.getElementById('showWeekly');
    Cur.className="nav-link active";
    this.sService.weatherSearch('',0,this.reLat, this.reLng);
    // document.getElementById('appCurrent').style.display='none';
    // document.getElementById('appHourly').style.display='none';
    // document.getElementById('appWeekly').style.display='block';
  }

}
