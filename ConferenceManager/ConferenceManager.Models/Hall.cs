namespace ConferenceManager.Models
{
    using System.ComponentModel.DataAnnotations;

    public class Hall
    {
        [Key]
        public int Id { get; set; }

        [Required]
        public string Name { get; set; }

        [Required]
        public int Capacity { get; set; }
    }
}
