import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Subject } from 'rxjs';

const httpOptions = {
  headers: new HttpHeaders({ "Content-type": "application/json; charset=UTF-8" })
};

@Injectable({
  providedIn: 'root'
})
export class SearchServiceService {

  constructor(public http:HttpClient) { }
  private searchUrl:string = "";
  private sealUrl:string = "";
  private darkUrl:string = "";
  public lat:string = "";
  public lng:string = "";
  public state:string="";
  public city:string = "";
  // public curLat:string = "";
  // public curLon:string = "";

  private jsonData: any;
  private _resultJson = new Subject();
  resultJson = this._resultJson.asObservable();

  private sealData: any;
  private _sealJson = new Subject();
  sealJson = this._sealJson.asObservable();

  private weatherData: any;
  private _weatherJson = new Subject();
  weatherJson = this._weatherJson.asObservable();

  private _clear = new Subject();
  Clear = this._clear.asObservable();

  private dateData: any=[];
  private _dateJson = new Subject();
  dateJson = this._dateJson.asObservable();

  search(form, flag){
    // 找到经纬度值 geocode api
    if(flag==0){
      this.city = form.myCity;
      this.state = form.myState;
    }else{
      this.city = form.myCity2;
      this.state = form.myState2;
      // this.curLat = form.myLat;
      // this.curLon = form.myLng;
    }
    this.searchUrl = "";
    this.searchUrl += form.myStreet+',';
    this.searchUrl += form.myCity+',';
    this.searchUrl += form.myState+'&key=AIzaSyCUbX3thvUqn4ul82mYU9guuASGixoH-SI';
    console.log('geourl: ', this.searchUrl);
    this.createNewSearch(this.searchUrl);

  }

  searchFavorite(myCity, myState){
    // 找到经纬度值 geocode api
  
    // this.city = myCity;
    // this.state = myState;
    this.city = myCity;
    this.state = myState;

    this.searchUrl = "";
    this.searchUrl += myCity+',';
    this.searchUrl += myState+'&key=AIzaSyCUbX3thvUqn4ul82mYU9guuASGixoH-SI';
    console.log('geourl: ', this.searchUrl);
    this.createNewSearch(this.searchUrl);

  }

  clear() {
    this._clear.next(true);
  }

  createNewSearch(url:string){
    let params={
      'geoUrl':url,
    }

    const headers = new HttpHeaders().set(
      "Content-type",
      "application/json; charset=UTF-8"
    );

    this.http.post(
      "/searchgeo",
      JSON.stringify(params),
      {headers}
    ).subscribe(
      (val:any) => {
        console.log("geo Post call successful value returned in body, ", val);
        this.jsonData = val;
        this._resultJson.next(this.jsonData);
        // console.log(this.resultJson);
        // console.log('haha: ', this.jsonData[0]);
        // console.log(this.jsonData[0].geometry.location.lat, this.jsonData[0].geometry.location.lng);
      },
      error => {
        console.log("geo Post call in error, ", error);
      },
      () => {
        console.log("geo The Post observable is now completed.");
      }
    );

    document.getElementById('myNav').style.display="block";
    var tabs = document.getElementsByClassName("nav-link")
    for(var i=0; i<tabs.length; i++){
      tabs[i].className="nav-link";
    }
    var Cur = document.getElementById('showCurrent');
    Cur.className="nav-link active";
  }

  sealSearch(){
    this.sealUrl = "";
    this.sealUrl += this.state;
    this.sealUrl += '%20State%20Seal&cx=014226069218176724898:ct0iplcwprm&imgSize=huge&imgType=news&num=1&searchType=image&key=AIzaSyCUbX3thvUqn4ul82mYU9guuASGixoH-SI';
    console.log('sealurl: ', this.sealUrl);
    let params={
      'sealUrl':this.sealUrl,
    }
    const headers = new HttpHeaders().set(
      "Content-type",
      "application/json; charset=UTF-8"
    );

    this.http.post(
      "/searchseal",
      JSON.stringify(params),
      {headers}
    ).subscribe(
      (val:any) => {
        console.log("seal Post call successful value returned in body, ", val);
        this.sealData = val;
        this._sealJson.next(this.sealData);
        // console.log(this.sealJson);
      },
      error => {
        console.log("seal Post call in error, ", error);
      },
      () => {
        console.log("seal The Post observable is now completed.");
      }
    );
  }

  weatherSearch(resultJson:any, flag:any, myLat, myLng){
    // 找到天气情况 darksky api
    this.darkUrl = "";
    this.lat = "";
    this.lng = "";
    if(flag && resultJson.length>0){
      this.lat = resultJson[0].geometry.location.lat;
      this.lng = resultJson[0].geometry.location.lng;
    }else{
      this.lat = myLat;
      this.lng = myLng;
    }
    
    this.darkUrl += 'b4ab8a86fdb8c045bb2c056963dba9b9/';
    this.darkUrl += this.lat+',';
    this.darkUrl += this.lng;
    console.log(this.darkUrl);

    let params={
      'weatherUrl':this.darkUrl,
    }
    const headers = new HttpHeaders().set(
      "Content-type",
      "application/json; charset=UTF-8"
    );

    this.http.post(
      '/searchweather',
      JSON.stringify(params),
      {headers}
    ).subscribe(
      (val:any) => {
        console.log("weather Post call successful value returned in body, ", val);
        
        this.weatherData = val;
        this._weatherJson.next(this.weatherData);
      },
      error => {
        console.log("weather Post call in error", error);
      },
      () => {
        console.log("The weather Post observable is now complete.");
      }
    );
  }

  // public date_lat:string;
  // public date_lon:string;
  // public date_time:string;
  public dateUrl:string = '';

  dateSearch(latitude:any, longitude:any, time:any){
    this.dateData = [];
    for(var i=0; i<7; i++){
      this.dateUrl = '';
      this.dateUrl+='b4ab8a86fdb8c045bb2c056963dba9b9/';
      this.dateUrl+=latitude;
      this.dateUrl+=',';
      this.dateUrl+=longitude;
      this.dateUrl+=',';
      this.dateUrl+=time[i];
    
      let params={
        'dateUrl':this.dateUrl,
      }
      const headers = new HttpHeaders().set(
        "Content-type",
        "application/json; charset=UTF-8"
      );

      this.http.post(
        '/searchdate',
        JSON.stringify(params),
        {headers}
      ).subscribe(
        (val:any) => {
          console.log("date Post call successful value returned in body, ", val);
          this.dateData.push(val);
          this._dateJson.next(this.dateData);
        },
        error => {
          console.log("date Post call in error", error);
        },
        () => {
          console.log("The date Post observable is now complete.");
        }
        );
      }
  }


  private _favorite = new Subject();
  favoriteList = this._favorite.asObservable();

  addFavorite(address){
    localStorage.setItem(address['city'],JSON.stringify(address));
    this.getAllFavorite();
  }

  getAllFavorite(){
    let localStorageArray = new Array(localStorage.length);
    for(let i=0; i<localStorage.length; i++){
      localStorageArray[i] = localStorage.getItem(localStorage.key(i));
    }
    this._favorite.next(localStorageArray);
  }

  removeFavorite1(key){
    localStorage.removeItem(key);
    this.getAllFavorite();
  }
  
  removeFavorite2(key,favoriteList){
    localStorage.removeItem(key);
    favoriteList = favoriteList.filter( item => item.city != key);
    this.getAllFavorite();
  }


  
}
