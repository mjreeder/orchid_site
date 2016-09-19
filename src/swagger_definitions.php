<?php

/**
 * @SWG\Definition(
 * 	    definition="ArrayPlantsSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Plants"
 *             )
 *      )
 * 	 )
 * @SWG\Definition(
 * 	    definition="SinglePlantSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Plants")
 * 	 )

 *
 *
 * @SWG\Definition(
 * 	    definition="ArrayBloom_CommentSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Bloom_Comment"
 *             )
 *      )
 * 	 )
 * @SWG\Definition(
 * 	    definition="SingleBloom_CommentSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Bloom_Comment")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayBloomingSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Blooming"
 *             )
 *      )
 * 	 )
 * @SWG\Definition(
 * 	    definition="SingleBloomingSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Blooming")
 * 	 )
 * @SWG\Definition(
 * 	    definition="ArrayClassification_LinkSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Classification_Link"
 *             )
 *      )
 * 	 )
 * @SWG\Definition(
 * 	    definition="SingleClassification_LinkSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Classification_Link")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayClassificationSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Classification"
 *             )
 *      )
 * 	 )
 * @SWG\Definition(
 * 	    definition="SingleClassificationSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Classification")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayCountrySuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Country"
 *             )
 *      )
 * 	 )
 * @SWG\Definition(
 * 	    definition="SingleCountrySuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Country")
 * 	 )
 *
 *
 * @SWG\Definition(
 * 	    definition="ArrayHealthSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Health"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleHealthSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Health")
 * 	 )
 *
 *
 * @SWG\Definition(
 * 	    definition="ArrayLocationSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Location"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleLocationSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Location")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayNotesSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Notes"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleNotesSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Notes")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayPestsSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Pests"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SinglePestsSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Pests")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayPhotosSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Photos"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SinglePhotosSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Photos")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayPottingSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Potting"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SinglePottingSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Potting")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayScientific_ClassSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Scientific_Class"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleScientific_ClassSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Scientific_Class")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArraySessionSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Session"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleSessionSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Session")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArraySpecial_CollectionSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Special_Collection"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleSpecial_CollectionSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Special_Collection")
 * 	 )
*
 * @SWG\Definition(
 * 	    definition="ArraySplitSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Split"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleSplitSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Split")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArraySprayedSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Sprayed"
 *             )
 *      )
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="SingleSprayedSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Sprayed")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayTagSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/Tag"
 *             )
 *      )
 * 	 )
 * @SWG\Definition(
 * 	    definition="SingleTagSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/Tag")
 * 	 )
 *
 * @SWG\Definition(
 * 	    definition="ArrayUserSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", type="array", required=true,
 *          @SWG\Items(
 *                 ref="#/definitions/User"
 *             )
 *      )
 * 	 )
 * @SWG\Definition(
 * 	    definition="SingleUserSuccess",
 * 		required={"status", "error", "message"},
 *		@SWG\Property(property="status", type="integer", default=200),
 *		@SWG\Property(property="error", type="boolean", default=false),
 *		@SWG\Property(property="message", type="string"),
 *      @SWG\Property(property="data", required=true, ref="#/definitions/User")
 * 	 )
 *
 *
 * @SWG\Definition(
 * 	    definition="PostBody",
 *      type="object",
 * 		required={"name", "author", "isbn"},
 *		@SWG\Property(property="name", type="string"),
 *		@SWG\Property(property="author", type="string"),
 *		@SWG\Property(property="isbn", type="string", default="1-2222-3333-4")
 * 	 )
 */

/**
 * @SWG\Parameter(
 *      parameter="AuthHeader",
 * 	    name="Authorization",
 *      in="header",
 *      description="Permission Authorization",
 * 		required=true,
 *		type="string",
 *      default="Bearer password"
 * 	 )
 *
 * @SWG\Parameter(
 * 	    name="plant_id",
 *      in="path",
 *      description="a plant id",
 * 		  required=true,
 *		  type="int",
 *      default="1"
 * 	 )
 *
 *
 * @SWG\Parameter(
 * 	    name="accession_number",
 *      in="path",
 *      description="a plant accession number",
 * 		  required=true,
 *		  type="string",
 *      default="1"
 * 	 )
 *
 * @SWG\Parameter(
 *      name="plant_name",
 *      in="formData",
 *      description="The Plant's name",
 *      required=false,
 *      type="string",
 *      format=""
 *     )
 *
*/
