import { Component, OnInit, Input } from '@angular/core';
import { HttpClient } from '@angular/common/http'
import { environment } from '../../environments/environment';
import { MapsAPILoader } from '@agm/core';
import { NgbActiveModal } from '@ng-bootstrap/ng-bootstrap';
import { LocationService } from '../_services/location.service';

@Component({
  selector: 'app-google-map',
  templateUrl: './google-map.component.html',
  styles: ['agm-map {height: 300px;}']
})
export class GoogleMapComponent implements OnInit {
  @Input() locId;
  location: any;
  name: string;
  address: string;
  latitude: number;
  longitude: number;
  zoom: number;  

  constructor(
    private http:HttpClient,
    private mapsAPILoader: MapsAPILoader,
    private service: LocationService,
    public activeModal: NgbActiveModal
  ) { }

  ngOnInit(): void {    
    this.service.getLocation(this.locId).subscribe(res => {
      this.location = res as Location[];      
      this.mapsAPILoader.load().then(() => {
        if ('geolocation' in navigator) {          
          navigator.geolocation.getCurrentPosition((position) => {
            this.name = this.location.data.name;
            this.latitude = this.location.data.latitude;
            this.longitude = this.location.data.longitude;
            this.address = this.location.data.address;
            this.zoom = 16;
          });
        }
      });
    },
    err => {
      console.log(err);
    });       
  }

  closeModal(sendData) { 
    this.activeModal.close(sendData); 
  }

}
