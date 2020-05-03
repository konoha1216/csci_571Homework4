import { Component, OnInit } from '@angular/core';

import {SearchServiceService} from '../../service/search-service.service'

@Component({
  selector: 'app-search-form',
  templateUrl: './search-form.component.html',
  styleUrls: ['./search-form.component.css']
})
export class SearchFormComponent implements OnInit {

  public isdisabled:boolean = false;
  public showResult = false;

  public form:any={
    myStreet:'',
    myCity:'',
    myState:'0',
    currentLocation:false,
  }

  public geodata:any;
  public sealdata:any;

  public curLat:string;
  public curLng:string;

  constructor(public sService:SearchServiceService) { 
    this.sService.resultJson.subscribe(data =>{
      console.log(data);
      this.geodata = data['results'];
      console.log(this.geodata);

      if(!this.form.currentLocation){
        this.sService.weatherSearch(this.geodata,1,'','');
      }else{
        this.sService.weatherSearch(this.geodata,0,this.curLat, this.curLng);
      }
      // this.sService.weatherSearch(this.geodata,1);
      this.sService.sealSearch();
    })
  }

  ngOnInit() {
    console.log(this.form.myStreet);
    console.log(this.form.myCity);
  }

  clear(){
    this.form.myStreet='';
    this.form.myCity='';
    this.form.myState='0';
    this.form.currentLocation=false;
    // document.getElementById('showContent').style.display='none';
  }

  getLocation(){
    var xmlhttp= new XMLHttpRequest();
    xmlhttp.open("GET","http://ip-api.com/json",false);
    xmlhttp.send();
    if(xmlhttp.status==404){ //url不存在
        alert(" locating failed.");
    }
    else{
        var json=JSON.parse(xmlhttp.responseText);
        console.log(json);
        // let currentZipcode =json['zip'];
        this.form.myCity2 = json['city'];
        this.form.myState2 = json['region'];
        this.curLat = json['lat'];
        this.curLng = json['lon'];
    }
  }

  current(){
    if(!this.form.currentLocation){
      this.form.myStreet='';
      this.form.myCity='';
      this.form.myState='0';
      this.isdisabled=true;
    }else{
      this.isdisabled=false;
    }
  }
    

  // }

  onSubmit(){
    if(this.form.currentLocation){
      this.getLocation();
      this.sService.search(this.form, 1);
    }
    else{
      this.sService.search(this.form, 0);
    }

    console.log('on Submit trigger!!!!!!!!!!')
    if(document.getElementById('resultButton').style.backgroundColor='white'){
      console.log('result button clicked!!!!!!!!! and is white')
      document.getElementById('resultButton').style.backgroundColor='rgb(74, 135, 167)';
      document.getElementById('resultButton').style.color='white';
      document.getElementById('favoriteButton').style.backgroundColor='white';
      document.getElementById('favoriteButton').style.color='#6C767D';
    }
    // document.getElementById('showFavorites').style.display="none";
    // else{
    //   document.getElementById('favoriteButton').style.backgroundColor='rgb(74, 135, 167)';
    //   document.getElementById('favoriteButton').style.color='white';

    //   document.getElementById('resultButton').style.backgroundColor='white';
    //   document.getElementById('resultButton').style.color='#6C767D';
    // }

    // document.getElementById('myNav').style.display='block';
    
    this.showResult = true;
  
  }

  favorite(){
    // document.getElementById('myNav').style.display='none';
    if(document.getElementById('favoriteButton').style.backgroundColor='white'){
      document.getElementById('favoriteButton').style.backgroundColor='rgb(74, 135, 167)';
      document.getElementById('favoriteButton').style.color='white';

      document.getElementById('resultButton').style.backgroundColor='white';
      document.getElementById('resultButton').style.color='#6C767D';
    }
    // document.getElementById('showFavorites').style.display="block";
    // else{
    //   document.getElementById('favoriteButton').style.backgroundColor='white';
    //   document.getElementById('favoriteButton').style.color='#6C767D';
    //   document.getElementById('resultButton').style.backgroundColor='rgb(74, 135, 167)';
    //   document.getElementById('resultButton').style.color='white';
    // }
  }

}
