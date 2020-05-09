import { Component, OnInit } from '@angular/core';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';
import { LabService } from '../_services/lab.service';
import { GoogleMapComponent } from '../google-map/google-map.component';
import Swal from 'sweetalert2'
import { Lab } from '../_models/lab.model';

@Component({
  selector: 'app-lab-list',
  templateUrl: './lab-list.component.html',
  styles: [
  ]
})
export class LabListComponent implements OnInit {

  constructor(public service: LabService, private modalService: NgbModal) { }

  ngOnInit(): void {
    this.service.reloadList();
  }

  fillForm(selected){ 
    this.service.formData = Object.assign({},selected);
  }

  onDelete(id: number) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You will not be able to recover this record!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, keep it'
    }).then((result) => {
      if (result.value) {
        this.service.deleteLab(id)
        .subscribe(
          data => {
            Swal.fire(
              'Deleted!',
              'The Record has been deleted.',
              'success'
            );
            this.service.reloadList();
          },
          error => console.log(error));
        
      // For more information about handling dismissals please visit
      // https://sweetalert2.github.io/#handling-dismissals
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire(
          'Cancelled',
          'Your record is safe :)',
          'error'
        )
      }
    });    
  }

  openGoogelMapsModal(id: number) {
    const modalRef = this.modalService.open(GoogleMapComponent,
    {
      scrollable: true
    });
    let data = {
      prop1: 'Some Data',
      prop2: 'From Parent Component',
      prop3: 'This Can be anything'
    }
 
    modalRef.componentInstance.locId = id;
  }
}
