 <!-- small modal -->
 <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-sm" role="document">
         <div class="modal-content">
             <div class="modal-header">
            <a href="{{$href}}"><span class="close" aria-hidden="true">&times;</span></a>
             </div>
             <div class="modal-body" id="smallBody">
                 <div>
                     {{$slot}}
                 </div>
             </div>
         </div>
     </div>
 </div>

 <style>
     /* The Modal (background) */
     .modal {
         display: none;
         /* Hidden by default */
         position: fixed;
         /* Stay in place */
         z-index: 1;
         /* Sit on top */
         padding-top: 100px;
         /* Location of the box */
         left: 0;
         top: 0;
         width: 100%;
         /* Full width */
         height: 100%;
         /* Full height */
         overflow: auto;
         /* Enable scroll if needed */
         background-color: rgb(0, 0, 0);
         /* Fallback color */
         background-color: rgba(0, 0, 0, 0.4);
         /* Black w/ opacity */
     }

     /* Modal Content */
     .modal-content {
         background-color: #fefefe;
         margin: auto;
         padding: 20px;
         border: 1px solid #888;
         width: 30%;
         margin-top: 15rem;
     }

     /* The Close Button */
     .close {
         color: #aaaaaa;
         float: right;
         font-size: 28px;
         font-weight: bold;
     }

     .close:hover,
     .close:focus {
         color: #000;
         text-decoration: none;
         cursor: pointer;
     }
 </style>