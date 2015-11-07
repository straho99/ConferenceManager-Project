namespace ConferenceManager.Models
{
    using System.ComponentModel.DataAnnotations;

    public class Break
    {
        [Key]
        public int Id { get; set; }

        [Required]
        public string Title { get; set; }

        public string Description { get; set; }

        [Required]
        public int LectureId { get; set; }

        public virtual Lecture Lecture { get; set; }
    }
}
