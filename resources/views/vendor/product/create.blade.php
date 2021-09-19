@extends('vendor.layouts.vendor')

@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href=""> المنتجات </a>
                                </li>
                                <li class="breadcrumb-item active">اضافة منتج
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">اضافة منتج  </h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">


                                        <form class="form" action="{{route('vendor.Product.store')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf






                                            <div class="form-group">
                                                <label> صوره المنتج </label>
                                                <input type="hidden" value="{{Auth::guard('vendor')->user()->id}}" name="vendor_id">
                                            <div class="input-group control-group increment" >
                                                <input type="file" name="photo[]" >
                                                <div class="input-group-btn">
                                                  <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                                </div>
                                              </div>
                                              <div class="clone hide">
                                                <div class="control-group input-group" style="margin-top:10px">
                                                  <input type="file" name="photo[]" >
                                                  <div class="input-group-btn">
                                                    <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                  </div>
                                                </div>
                                            </div>
                                            @error('photo')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>

                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> بيانات المنتج </h4>


                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> اسم المنتج  </label>
                                                                    <input type="text" value="" id="title"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           name="title">
                                                                    @error("title")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>



                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> سعر المنتج  </label>
                                                                    <input type="text" value="" id="price"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           name="price">
                                                                    @error("price")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>



                                                        </div>






                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> وصف المنتج  </label>
                                                                    <textarea class="form-control" id="exampleFormControlTextarea1"  name="description" rows="3"></textarea>

                                                                    @error("description")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>



                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput1"> الخصم على المنتج  </label>
                                                                    <input type="integer" value="" id="discount"
                                                                           class="form-control"
                                                                           placeholder="  "
                                                                           name="discount">
                                                                    @error("discount")
                                                                    <span class="text-danger"> هذا الحقل مطلوب</span>
                                                                    @enderror
                                                                </div>
                                                            </div>



                                                        </div>

                                                        <div class="row">




                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput2"> أختر القسم </label>
                                                                    <select name="category_id" class="select2 form-control">
                                                                        <optgroup label="من فضلك أختر القسم ">
                                                                            @if($subcategories && $subcategories -> count() > 0)
                                                                                @foreach($subcategories as $subcategory)
                                                                                    <option
                                                                                        value="{{$subcategory -> id }}">{{$subcategory -> name}}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </optgroup>
                                                                    </select>
                                                                    @error('category_id')
                                                                    <span class="text-danger"> {{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="projectinput2"> أختر الكمية </label>
                                                                    <select name="stock" class="select2 form-control">
                                                                        <optgroup label="من فضلك أختر الكمية ">
                                                                            @for($i = 1; $i < 200; $i++)


                                                                                    <option value="{{$i }}">{{$i}}</option>

                                                                                    @endfor
                                                                        </optgroup>
                                                                    </select>
                                                                    @error('stock')
                                                                    <span class="text-danger"> {{$message}}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>



                                                            <div class="col-md-6">
                                                                <div class="form-group mt-1">
                                                                    <input type="checkbox" value="1"
                                                                           name="active"
                                                                           id="switcheryColor4"
                                                                           class="switchery" data-color="success"
                                                                           checked/>
                                                                    <label for="switcheryColor4"
                                                                           class="card-title ml-1">الحالة  </label>

                                                                    @error("active")
                                                                    <span class="text-danger"> </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                            </div>


                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> تراجع
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>

<script type="text/javascript">
    $(document).ready(function() {
      $(".btn-success").click(function(){
          var html = $(".clone").html();
          $(".increment").after(html);
      });
      $("body").on("click",".btn-danger",function(){
          $(this).parents(".control-group").remove();
      });
    });
</script>
    </div>

@endsection
